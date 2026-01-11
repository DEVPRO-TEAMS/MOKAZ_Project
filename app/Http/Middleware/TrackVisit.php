<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitHistorique;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

class TrackVisit
{
//     public function handle(Request $request, Closure $next)
// {
//     $ip = $request->ip();
//     $userAgent = $request->userAgent();

//     // 🔎 Chercher une visite EXISTANTE aujourd'hui
//     $visit = Visit::where('ip_address', $ip)
//         ->where('user_agent', $userAgent)
//         ->whereDate('started_at', today())
//         ->first();

//     $country = null;
//     $city = null;
//     $latitude = null;
//     $longitude = null;

//     // 🌍 Géolocalisation
//     $position = Location::get($ip);
//     if ($position) {
//         $country = $position->countryName ?? null;
//         $city = $position->cityName ?? null;
//         $latitude = $position->latitude ?? null;
//         $longitude = $position->longitude ?? null;
//     }

//     if ($visit) {
//         // 🔄 Mise à jour de la visite existante
//         Log::info('Visite existante ' . $ip . ' ' . $userAgent);
//         $visit->update([
//             'coordornneGPS' => $latitude && $longitude
//                 ? $latitude . ',' . $longitude
//                 : $visit->coordornneGPS, // garder l'ancienne si pas de nouvelles coordonnées
//             'country'      => $country ?? $visit->country,
//             'city'         => $city ?? $visit->city,
//             'updated_at'   => now(),
//         ]);
//     } else {

//         Log::info('Nouvelle visite ' . $ip . ' ' . $userAgent);
//         // ❌ Aucune visite aujourd’hui → on crée
//         $visit = Visit::create([
//             'uuid'        =>  Str::uuid(),
//             'ip_address'  => $ip,
//             'user_agent'  => $userAgent,
//             'source'      => $this->detectSource($request),
//             'referrer'    => $request->headers->get('referer'),
//             'coordornneGPS'=> $latitude && $longitude
//                 ? $latitude . ',' . $longitude
//                 : null,
//             'country'     => $country,
//             'city'        => $city,
//             'started_at'  => now(),
//         ]);
//     }

//     // 🧠 Toujours stocker la visite du jour
//     session(['visit_uuid' => $visit->uuid]);

//     return $next($request);
// }

    // public function handle(Request $request, Closure $next)
    // {
    //     $ip        = $request->ip();
    //     $userAgent = $request->userAgent();

    //     /**
    //      * 1️⃣ VISITEUR UNIQUE DU JOUR
    //      */
    //     $visit = Visit::where('ip_address', $ip)
    //         ->where('user_agent', $userAgent)
    //         ->whereDate('created_at', today())
    //         ->first();

    //     if (!$visit) {
    //         $visit = Visit::create([
    //             'uuid'        => (string) Str::uuid(),
    //             'ip_address'  => $ip,
    //             'user_agent'  => $userAgent,
    //         ]);
    //     }

    //     /**
    //      * 2️⃣ AUTO-FERMETURE DES SESSIONS INACTIVES (> 30 min)
    //      */
    //     VisitHistorique::where('visit_uuid', $visit->uuid)
    //         ->whereNull('ended_at')
    //         ->where('started_at', '<', now()->subMinutes(30))
    //         ->update([
    //             'ended_at' => now(),
    //             'duration' => DB::raw('TIMESTAMPDIFF(SECOND, started_at, NOW())'),
    //         ]);

    //     /**
    //      * 3️⃣ GÉOLOCALISATION
    //      */
    //     $country = $city = $latitude = $longitude = null;

    //     if ($position = Location::get($ip)) {
    //         $country   = $position->countryName ?? null;
    //         $city      = $position->cityName ?? null;
    //         $latitude  = $position->latitude ?? null;
    //         $longitude = $position->longitude ?? null;
    //     }

    //     /**
    //      * 4️⃣ SESSION ACTIVE
    //      */
    //     $visitHistorique = VisitHistorique::where('visit_uuid', $visit->uuid)
    //         ->whereNull('ended_at')
    //         ->whereDate('started_at', today())
    //         ->first();

    //     if (!$visitHistorique) {
    //         $visitHistorique = VisitHistorique::create([
    //             'uuid'           => (string) Str::uuid(),
    //             'visit_uuid'     => $visit->uuid,
    //             'source'         => $this->detectSource($request),
    //             'referrer'       => $request->headers->get('referer'),
    //             'coordornneGPS'  => $latitude && $longitude ? "$latitude,$longitude" : null,
    //             'country'        => $country,
    //             'city'           => $city,
    //             'started_at'     => now(),
    //         ]);

    //         Log::info('Nouvelle session créée', ['uuid' => $visitHistorique->uuid]);
    //     }

    //     /**
    //      * 5️⃣ SESSION EN MÉMOIRE
    //      */
    //     session([
    //         'visit_uuid'             => $visit->uuid,
    //         'visit_historique_uuid'  => $visitHistorique->uuid,
    //     ]);

    //     return $next($request);
    // }

 public function handle(Request $request, Closure $next)
{
    $ip        = $request->ip();
    $userAgent = $request->userAgent();

    // 1️⃣ VISITEUR UNIQUE DU JOUR
    $visit = Visit::firstOrCreate(
        ['ip_address' => $ip, 'user_agent' => $userAgent],
        ['uuid' => (string) Str::uuid()]
    );

    // 2️⃣ GÉOLOCALISATION
    $country = $city = $latitude = $longitude = null;
    if ($position = Location::get($ip)) {
        $country   = $position->countryName ?? null;
        $city      = $position->cityName ?? null;
        $latitude  = $position->latitude ?? null;
        $longitude = $position->longitude ?? null;
    }

    // 3️⃣ RÉCUPÉRER LA SESSION ACTIVE DU VISITEUR
    // 🔹 On récupère la dernière session ouverte (ended_at = NULL)
    $visitHistorique = VisitHistorique::where('visit_uuid', $visit->uuid)
        ->whereNull('ended_at')
        ->latest('started_at')
        ->first();

    // 4️⃣ Vérifier si la session existe et est encore active
    if ($visitHistorique) {
        // Si inactivité > 30 min → fermeture automatique
        if (($visitHistorique->updated_at ?? $visitHistorique->started_at) < now()->subMinutes(30)) {
            $visitHistorique->update([
                'ended_at' => now(),
                'duration' => now()->diffInSeconds($visitHistorique->started_at),
            ]);
            $visitHistorique = null; // créer une nouvelle session ci-dessous
        } else {
            // Session toujours active → on ne crée pas de nouvelle session
            $visitHistorique->touch(); // met à jour updated_at pour suivi de l'activité
        }
    }

    // 5️⃣ Créer une nouvelle session si aucune session ouverte
    if (!$visitHistorique) {
        $visitHistorique = VisitHistorique::create([
            'uuid'          => (string) Str::uuid(),
            'visit_uuid'    => $visit->uuid,
            'source'        => $this->detectSource($request),
            'referrer'      => $request->headers->get('referer'),
            'coordornneGPS' => $latitude && $longitude ? "$latitude,$longitude" : null,
            'country'       => $country,
            'city'          => $city,
            'started_at'    => now(),
        ]);
    }

    // 6️⃣ Stocker la session active en mémoire
    session([
        'visit_uuid'            => $visit->uuid,
        'visit_historique_uuid' => $visitHistorique->uuid,
    ]);

    return $next($request);
}

/**
 * Détecte la source du visiteur (UTM, SEO, direct, social, ads)
 */
private function detectSource(Request $request): string
{
    if ($request->has('utm_source')) {
        return match ($request->utm_source) {
            'facebook', 'instagram', 'twitter', 'linkedin', 'pinterest', 'tiktok', 'snapchat', 'whatsapp' => 'social',
            'google' => 'ads',
            default => 'ads',
        };
    }

    $referer = $request->headers->get('referer');
    if ($referer && str_contains($referer, 'google')) {
        return 'seo';
    }

    return 'direct';
}
}
