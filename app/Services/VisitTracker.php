<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Visit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitHistorique;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

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
            Log::info('Aucune session en cours');
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
        $start = now()->startOfDay();
        $end   = now()->endOfDay();

        $visit = Visit::where('ip_address', $request->ip())
            ->where('user_agent', $request->userAgent())
            ->whereBetween('started_at', [$start, $end])
            ->first();

        if ($visit) {
            Log::info('Visite existante trouvée', ['visit_uuid' => $visit->uuid]);
            return $visit;
        }

        Log::info('Nouvelle visite crée', ['ip_address' => $request->ip(), 'user_agent' => $request->userAgent()]);
        return Visit::create([
            'uuid'       => (string) Str::uuid(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'started_at' => now(),
        ]);
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
        // 2️⃣ GÉOLOCALISATION
        $country = $city = $latitude = $longitude = null;
        if ($position = Location::get($request->ip())) {
            $country   = $position->countryName ?? null;
            $city      = $position->cityName ?? null;
            $latitude  = $position->latitude ?? null;
            $longitude = $position->longitude ?? null;
        }
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
            'coordornneGPS' => $latitude && $longitude ? "$latitude,$longitude" : null,
            'country'       => $country,
            'city'          => $city,
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
    
    // private function detectSource(Request $request): string
    // {
    //     // Logique existante améliorée
    //     if ($request->has('utm_source')) {
    //         $source = $request->utm_source;
            
    //         $socialSources = ['facebook', 'instagram', 'twitter', 'linkedin', 
    //                          'pinterest', 'tiktok', 'snapchat', 'whatsapp'];
            
    //         if (in_array(strtolower($source), $socialSources)) {
    //             return 'social';
    //         }
            
    //         if (strtolower($source) === 'google') {
    //             return $request->has('utm_medium') && $request->utm_medium === 'cpc' 
    //                 ? 'ads' 
    //                 : 'organic';
    //         }
            
    //         return 'referral';
    //     }
        
    //     $referer = $request->headers->get('referer');
    //     if ($referer) {
    //         if (str_contains(strtolower($referer), 'google')) {
    //             return 'organic';
    //         }
            
    //         $socialDomains = ['facebook.com', 'twitter.com', 'linkedin.com'];
    //         foreach ($socialDomains as $domain) {
    //             if (str_contains($referer, $domain)) {
    //                 return 'social';
    //             }
    //         }
            
    //         return 'referral';
    //     }
        
    //     return 'direct';
    // }

    private function detectSource(Request $request): string
{
    if ($request->has('utm_source')) {
        $source = strtolower($request->utm_source);
        $medium = strtolower($request->utm_medium ?? '');

        if (in_array($medium, ['cpc', 'ads', 'paid'])) {
            return 'ads';
        }

        if (in_array($source, ['facebook', 'instagram', 'twitter', 'linkedin', 'tiktok', 'snapchat', 'whatsapp'])) {
            return 'social';
        }

        if (in_array($source, ['google', 'bing', 'yahoo'])) {
            return 'organic';
        }

        if ($medium === 'email') {
            return 'email';
        }

        return 'referral';
    }

    $referer = strtolower($request->headers->get('referer', ''));

    if (str_contains($referer, 'google') || str_contains($referer, 'bing')) {
        return 'organic';
    }

    if (preg_match('/facebook|instagram|twitter|linkedin|tiktok/', $referer)) {
        return 'social';
    }

    return $referer ? 'referral' : 'direct';
}

}