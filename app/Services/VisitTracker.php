<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Visit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitHistorique;
use Illuminate\Support\Facades\DB;

class VisitTracker
{
    private int $inactivityTimeout = 30; // minutes
    
    public function handle(Request $request)
    {
        // Vérifier si déjà en session avec activité récente
        if ($this->hasActiveSession($request)) {
            return;
        }
        
        // Trouver ou créer la visite
        $visit = $this->findOrCreateVisit($request);
        
        // Gérer la session/historique
        $historique = $this->manageHistorique($visit, $request);
        
        // Stocker en session
        $this->storeInSession($visit, $historique);
    }
    
    private function hasActiveSession(Request $request): bool
    {
        if (!session()->has(['visit_uuid', 'visit_historique_uuid', 'last_activity'])) {
            return false;
        }
        
        $lastActivity = session('last_activity');
        
        // Vérifier l'inactivité
        if (Carbon::parse($lastActivity)->addMinutes($this->inactivityTimeout)->isPast()) {
            $this->closeExpiredHistorique();
            return false;
        }
        
        // Mettre à jour le timestamp d'activité
        session(['last_activity' => now()]);
        return true;
    }
    
    private function findOrCreateVisit(Request $request): Visit
    {
        return Visit::firstOrCreate(
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
            [
                'uuid' => Str::uuid(),
                'started_at' => now(),
            ]
        );
    }
    
    private function manageHistorique(Visit $visit, Request $request): VisitHistorique
    {
        $historique = $this->findActiveHistorique($visit);
        
        if (!$historique || $this->shouldStartNewSession($historique)) {
            return $this->createNewHistorique($visit, $request);
        }
        
        // Mettre à jour l'activité
        $historique->touch();
        return $historique;
    }
    
    private function findActiveHistorique(Visit $visit): ?VisitHistorique
    {
        return VisitHistorique::where('visit_uuid', $visit->uuid)
            ->whereNull('ended_at')
            ->first();
    }
    
    private function shouldStartNewSession(VisitHistorique $historique): bool
    {
        return $historique->updated_at->addMinutes($this->inactivityTimeout)->isPast();
    }
    
    private function createNewHistorique(Visit $visit, Request $request): VisitHistorique
    {
        // Fermer l'ancienne session si elle existe
        VisitHistorique::where('visit_uuid', $visit->uuid)
            ->whereNull('ended_at')
            ->update([
                'ended_at' => now(),
                'duration' => DB::raw('TIMESTAMPDIFF(SECOND, started_at, NOW())')
            ]);
        
        return VisitHistorique::create([
            'uuid' => Str::uuid(),
            'visit_uuid' => $visit->uuid,
            'source' => $this->detectSource($request),
            'referrer' => $request->headers->get('referer'),
            'started_at' => now(),
        ]);
    }
    
    private function storeInSession(Visit $visit, VisitHistorique $historique): void
    {
        session([
            'visit_uuid' => $visit->uuid,
            'visit_historique_uuid' => $historique->uuid,
            'last_activity' => now(),
        ]);
    }
    
    private function closeExpiredHistorique(): void
    {
        if ($uuid = session('visit_historique_uuid')) {
            VisitHistorique::where('uuid', $uuid)
                ->whereNull('ended_at')
                ->update([
                    'ended_at' => now(),
                    'duration' => DB::raw('TIMESTAMPDIFF(SECOND, started_at, NOW())')
                ]);
        }
        
        session()->forget(['visit_uuid', 'visit_historique_uuid', 'last_activity']);
    }
    
    private function detectSource(Request $request): string
    {
        // Logique existante améliorée
        if ($request->has('utm_source')) {
            $source = $request->utm_source;
            
            $socialSources = ['facebook', 'instagram', 'twitter', 'linkedin', 
                             'pinterest', 'tiktok', 'snapchat', 'whatsapp'];
            
            if (in_array(strtolower($source), $socialSources)) {
                return 'social';
            }
            
            if (strtolower($source) === 'google') {
                return $request->has('utm_medium') && $request->utm_medium === 'cpc' 
                    ? 'ads' 
                    : 'organic';
            }
            
            return 'referral';
        }
        
        $referer = $request->headers->get('referer');
        if ($referer) {
            if (str_contains(strtolower($referer), 'google')) {
                return 'organic';
            }
            
            $socialDomains = ['facebook.com', 'twitter.com', 'linkedin.com'];
            foreach ($socialDomains as $domain) {
                if (str_contains($referer, $domain)) {
                    return 'social';
                }
            }
            
            return 'referral';
        }
        
        return 'direct';
    }
}