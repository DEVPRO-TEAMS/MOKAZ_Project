<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Visit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\VisitTracker;
use App\Models\VisitHistorique;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

class TrackVisit
{

    // public function handle(Request $request, Closure $next)
    // {
    //     $ip        = $request->ip();
    //     $userAgent = $request->userAgent();

    //     // 1️⃣ VISITEUR UNIQUE DU JOUR
    //     $visit = Visit::firstOrCreate(
    //         ['ip_address' => $ip, 'user_agent' => $userAgent],
    //         ['uuid' => (string) Str::uuid()]
    //     );

    //     // 2️⃣ GÉOLOCALISATION
    //     $country = $city = $latitude = $longitude = null;
    //     if ($position = Location::get($ip)) {
    //         $country   = $position->countryName ?? null;
    //         $city      = $position->cityName ?? null;
    //         $latitude  = $position->latitude ?? null;
    //         $longitude = $position->longitude ?? null;
    //     }

    //     // 3️⃣ RÉCUPÉRER LA SESSION ACTIVE DU VISITEUR
    //     // 🔹 On récupère la dernière session ouverte (ended_at = NULL)
    //     $visitHistorique = VisitHistorique::where('visit_uuid', $visit->uuid)
    //         ->whereNull('ended_at')
    //         ->latest('started_at')
    //         ->first();

    //     // 4️⃣ Vérifier si la session existe et est encore active
    //     if ($visitHistorique) {
    //         // Si inactivité > 30 min → fermeture automatique
    //         if (($visitHistorique->updated_at ?? $visitHistorique->started_at) < now()->subMinutes(30)) {
    //             $visitHistorique->update([
    //                 'ended_at' => now(),
    //                 'duration' => now()->diffInSeconds($visitHistorique->started_at),
    //             ]);
    //             $visitHistorique = null; // créer une nouvelle session ci-dessous
    //         } else {
    //             // Session toujours active → on ne crée pas de nouvelle session
    //             $visitHistorique->touch(); // met à jour updated_at pour suivi de l'activité
    //         }
    //     }

    //     // 5️⃣ Créer une nouvelle session si aucune session ouverte
    //     if (!$visitHistorique) {
    //         $visitHistorique = VisitHistorique::create([
    //             'uuid'          => (string) Str::uuid(),
    //             'visit_uuid'    => $visit->uuid,
    //             'source'        => $this->detectSource($request),
    //             'referrer'      => $request->headers->get('referer'),
    //             'coordornneGPS' => $latitude && $longitude ? "$latitude,$longitude" : null,
    //             'country'       => $country,
    //             'city'          => $city,
    //             'started_at'    => now(),
    //         ]);
    //     }

    //     // 6️⃣ Stocker la session active en mémoire
    //     session([
    //         'visit_uuid'            => $visit->uuid,
    //         'visit_historique_uuid' => $visitHistorique->uuid,
    //     ]);

    //     return $next($request);
    // }

    // public function handle(Request $request, Closure $next)
    // {
    //     $ip        = $request->ip();
    //     $userAgent = $request->userAgent();

    //     /**
    //      * 1️⃣ VISITEUR UNIQUE par JOUR
    //      */
    //     $today = Carbon::now()->format('Y-m-d');
    //     $visit = Visit::where('ip_address', $ip)
    //     ->where('user_agent', $userAgent)
    //     ->whereDate('started_at', $today)
    //     ->first();

    //     if (!$visit) {
    //         $visit = Visit::create([
    //             'uuid'       => (string) Str::uuid(),
    //             'ip_address' => $ip,
    //             'user_agent' => $userAgent,
    //             'started_at' => now(),
    //         ]);
    //     }

    //     /**
    //      * 2️⃣ SESSION ACTIVE EXISTANTE ?
    //      */
    //     $visitHistorique = VisitHistorique::where('visit_uuid', $visit->uuid)
    //         ->whereNull('ended_at')
    //         ->latest('started_at')
    //         ->first();

    //     /**
    //      * 3️⃣ SI SESSION EXISTE
    //      */
    //     if ($visitHistorique) {

    //         // ⏱ Inactivité > 30 min → fermer
    //         if ($visitHistorique->updated_at < now()->subMinutes(30)) {
    //             $visitHistorique->update([
    //                 'ended_at' => now(),
    //                 'duration' => now()->diffInSeconds($visitHistorique->started_at),
    //             ]);
    //             $visitHistorique = null;
    //         } else {
    //             // Toujours actif → simple activité
    //             $visitHistorique->touch();
    //         }
    //     }

    //     /**
    //      * 4️⃣ CRÉATION SESSION SI AUCUNE OU FERMÉE
    //      */
    //     if (!$visitHistorique) {
    //         $visitHistorique = VisitHistorique::create([
    //             'uuid'       => (string) Str::uuid(),
    //             'visit_uuid' => $visit->uuid,
    //             'source'     => $this->detectSource($request),
    //             'referrer'   => $request->headers->get('referer'),
    //             'started_at' => now(),
    //         ]);
    //     }

    //     /**
    //      * 5️⃣ SESSION PHP
    //      */
    //     session([
    //         'visit_uuid'            => $visit->uuid,
    //         'visit_historique_uuid' => $visitHistorique->uuid,
    //     ]);

    //     return $next($request);
    // }

    /**
     * 0️⃣ VISITE DÉJÀ EN SESSION → ON SORT
     */
    // if (session()->has('visit_uuid')) {
    //     return $next($request);
    // }else {
    // }
    // public function handle(Request $request, Closure $next)
    // {
    //     /**
    //      * 0️⃣ VISITE DÉJÀ EN SESSION → ON SORT
    //      */
    //     if (session()->has('visit_uuid') && session()->has('visit_historique_uuid')) {
    //         Log::info('Session existante', ['visit_uuid' => session('visit_uuid'), 'visit_historique_uuid' => session('visit_historique_uuid')]);
    //         return $next($request);
    //     }



    //     $ip        = $request->ip();
    //     $userAgent = $request->userAgent();

    //     /**
    //      * 1️⃣ DERNIÈRE VISITE CONNUE
    //      */
    //     $lastVisit = Visit::where('ip_address', $ip)
    //         ->where('user_agent', $userAgent)
    //         ->latest('started_at')
    //         ->first();
        
    //     Log::info('lastVisit', ['lastVisit' => $lastVisit]);

    //     /**
    //      * 2️⃣ VISITE DU JOUR ?
    //      */
    //     if (!$lastVisit || !$lastVisit->started_at->isToday()) {

    //         $visit = Visit::create([
    //             'uuid'       => (string) Str::uuid(),
    //             'ip_address' => $ip,
    //             'user_agent' => $userAgent,
    //             'started_at' => now(),
    //         ]);
    //         Log::info('Nouvelle visite', ['visit' => $visit]);
    //     } else {
    //         $visit = $lastVisit;
    //     }

    //     /**
    //      * 3️⃣ SESSION ACTIVE EXISTANTE ?
    //      */
    //     $visitHistorique = VisitHistorique::where('visit_uuid', $visit->uuid)
    //         ->whereNull('ended_at')
    //         ->latest('started_at')
    //         ->first();

    //     /**
    //      * 4️⃣ SESSION EXISTE
    //      */
    //     if ($visitHistorique) {

    //         if ($visitHistorique->updated_at < now()->subMinutes(30)) {
    //             // ⛔ inactivité → fermeture
    //             $visitHistorique->update([
    //                 'ended_at' => now(),
    //                 'duration' => now()->diffInSeconds($visitHistorique->started_at),
    //             ]);
    //             $visitHistorique = null;
    //         } else {
    //             // activité normale
    //             $visitHistorique->touch();
    //         }
    //     }

    //     /**
    //      * 5️⃣ CRÉATION NOUVELLE SESSION SI NÉCESSAIRE
    //      */
    //     if (!$visitHistorique ) {
    //         $visitHistorique = VisitHistorique::create([
    //             'uuid'       => (string) Str::uuid(),
    //             'visit_uuid' => $visit->uuid,
    //             'source'     => $this->detectSource($request),
    //             'referrer'   => $request->headers->get('referer'),
    //             'started_at' => now(),
    //         ]);
    //     }

    //     /**
    //      * 6️⃣ MÉMORISATION SESSION
    //      */
    //     session([
    //         'visit_uuid'            => $visit->uuid,
    //         'visit_historique_uuid' => $visitHistorique->uuid,
    //     ]);

    //     return $next($request);
    // }



    // /**
    //  * Détecte la source du visiteur (UTM, SEO, direct, social, ads)
    //  */
    // private function detectSource(Request $request): string
    // {
    //     if ($request->has('utm_source')) {
    //         return match ($request->utm_source) {
    //             'facebook', 'instagram', 'twitter', 'linkedin', 'pinterest', 'tiktok', 'snapchat', 'whatsapp' => 'social',
    //             'google' => 'ads',
    //             default => 'ads',
    //         };
    //     }

    //     $referer = $request->headers->get('referer');
    //     if ($referer && str_contains($referer, 'google')) {
    //         return 'seo';
    //     }

    //     return 'direct';
    // }

    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldTrack($request)) {
            app(VisitTracker::class)->handle($request);
        }
        
        return $next($request);
    }

    private function shouldTrack(Request $request): bool
    {
        // Exclure certaines routes
        $excluded = [
            'horizon*', 'nova*', 'telescope*',
            'assets/*', 'storage/*', 'api/*', 'track/', 'sanctum/*',
        ];
        
        foreach ($excluded as $pattern) {
            if ($request->is($pattern)) {
                return false;
            }
        }
        
        // Exclure les robots et crawlers
        $userAgent = $request->userAgent();
        $crawlers = ['bot', 'crawl', 'spider', 'curl', 'wget'];
        
        foreach ($crawlers as $crawler) {
            if (stripos($userAgent, $crawler) !== false) {
                return false;
            }
        }
        
        return true;
    }
}


