<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Visit;
use Stevebauman\Location\Facades\Location;

// class TrackVisit
// {
//     public function handle(Request $request, Closure $next)
//     {
//         if (!session()->has('visit_uuid')) {

//             $ip = $request->ip();

//             $country = null;
//             $city = null;
//             $latitude = null;
//             $longitude = null;

//             // Récupération géolocalisation
//             $position = Location::get($ip);
//             if ($position) {
//                 $country = $position?->countryName ?? null;
//                 $city = $position?->cityName ?? null;
//                 $latitude = $position?->latitude ?? null;
//                 $longitude = $position?->longitude ?? null;

//                 // session(['lat' => $position->latitude, 'lng' => $position->longitude]);
//             }
            
//             $visit = Visit::create([
//                 'uuid'       => Str::uuid(),
//                 'ip_address' => $request->ip(),
//                 'user_agent' => $request->userAgent(),
//                 'source'     => $this->detectSource($request),
//                 'referrer'   => $request->headers->get('referer'),
//                 'coordornneGPS' => $latitude . ',' . $longitude,
//                 'country'    => $country,
//                 'city'       => $city,
//                 'started_at' => now(),
//             ]);

//             session(['visit_uuid' => $visit->uuid]);
//         }

//         return $next($request);
//     }

//     private function detectSource(Request $request): string
//     {
//         // UTM (campagnes marketing)
//         if ($request->has('utm_source')) {
//             return match ($request->utm_source) {
//                 'facebook', 'instagram' => 'social',
//                 'google' => 'ads',
//                 default => 'ads',
//             };
//         }

//         // Référent SEO
//         if ($request->headers->get('referer')) {
//             if (str_contains($request->headers->get('referer'), 'google')) {
//                 return 'seo';
//             }
//         }

//         return 'direct';
//     }
// }

class TrackVisit
{
    // public function handle(Request $request, Closure $next)
    // {
    //     $ip = $request->ip();
    //     $userAgent = $request->userAgent();

    //     // 🔎 Chercher une visite EXISTANTE aujourd'hui
    //     $visit = Visit::where('ip_address', $ip)
    //         ->where('user_agent', $userAgent)
    //         ->whereDate('started_at', today())
    //         ->first();

    //     // ❌ Aucune visite aujourd’hui → on crée
    //     if (!$visit) {

    //         $country = null;
    //         $city = null;
    //         $latitude = null;
    //         $longitude = null;

    //         // 🌍 Géolocalisation
    //         $position = Location::get($ip);
    //         if ($position) {
    //             $country = $position->countryName ?? null;
    //             $city = $position->cityName ?? null;
    //             $latitude = $position->latitude ?? null;
    //             $longitude = $position->longitude ?? null;
    //         }

    //         $visit = Visit::create([
    //             'uuid'       => (string) Str::uuid(),
    //             'ip_address' => $ip,
    //             'user_agent' => $userAgent,
    //             'source'     => $this->detectSource($request),
    //             'referrer'   => $request->headers->get('referer'),
    //             'coordornneGPS' => $latitude && $longitude
    //                 ? $latitude . ',' . $longitude
    //                 : null,
    //             'country'    => $country,
    //             'city'       => $city,
    //             'started_at' => now(),
    //         ]);
    //     }

    //     // 🧠 Toujours stocker la visite du jour
    //     session(['visit_uuid' => $visit->uuid]);

    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next)
{
    $ip = $request->ip();
    $userAgent = $request->userAgent();

    // 🔎 Chercher une visite EXISTANTE aujourd'hui
    $visit = Visit::where('ip_address', $ip)
        ->where('user_agent', $userAgent)
        ->whereDate('started_at', today())
        ->first();

    $country = null;
    $city = null;
    $latitude = null;
    $longitude = null;

    // 🌍 Géolocalisation
    $position = Location::get($ip);
    if ($position) {
        $country = $position->countryName ?? null;
        $city = $position->cityName ?? null;
        $latitude = $position->latitude ?? null;
        $longitude = $position->longitude ?? null;
    }

    if ($visit) {
        // 🔄 Mise à jour de la visite existante
        $visit->update([
            // 'source'       => $this->detectSource($request),
            // 'referrer'     => $request->headers->get('referer'),
            'coordornneGPS' => $latitude && $longitude
                ? $latitude . ',' . $longitude
                : $visit->coordornneGPS, // garder l'ancienne si pas de nouvelles coordonnées
            'country'      => $country ?? $visit->country,
            'city'         => $city ?? $visit->city,
            'updated_at'   => now(),
        ]);
    } else {
        // ❌ Aucune visite aujourd’hui → on crée
        $visit = Visit::create([
            'uuid'        =>  Str::uuid(),
            'ip_address'  => $ip,
            'user_agent'  => $userAgent,
            'source'      => $this->detectSource($request),
            'referrer'    => $request->headers->get('referer'),
            'coordornneGPS'=> $latitude && $longitude
                ? $latitude . ',' . $longitude
                : null,
            'country'     => $country,
            'city'        => $city,
            'started_at'  => now(),
        ]);
    }

    // 🧠 Toujours stocker la visite du jour
    session(['visit_uuid' => $visit->uuid]);

    return $next($request);
}


    private function detectSource(Request $request): string
    {
        if ($request->has('utm_source')) {
            return match ($request->utm_source) {
                'facebook', 'instagram', 'twitter', 'linkedin', 'pinterest', 'tiktok', 'snapchat', 'whatsapp' => 'social',
                'google' => 'ads',
                default => 'ads',
            };
        }

        if ($request->headers->get('referer')) {
            if (str_contains($request->headers->get('referer'), 'google')) {
                return 'seo';
            }
        }

        return 'direct';
    }
}
