<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\PageView;
use Illuminate\Support\Facades\Log;

class TrackPageView
{
    // public function handle($request, Closure $next)
    // {
    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        // Ignore si pas de visite
        if (!session()->has('visit_uuid')) {
            return $next($request);
        }

        $url = $request->path();

        // 🔹 Ignorer les fichiers statiques et la route de tracking
        $ignoredPrefixes = [
            'storage/',
            'track/',
            'assets/',
            'api/',
        ];

        foreach ($ignoredPrefixes as $prefix) {
            if (str_starts_with($url, $prefix)) {
                return $next($request); // ne pas tracker
            }
        }

        $pageType = $this->resolvePageType($url);

        $pageView = PageView::where('visit_uuid', session('visit_uuid'))
            ->where('url', $url)
            ->where('page_type', $pageType)
            ->whereDate('created_at', today())
            ->first();

        if (!$pageView) {
            $pageView = PageView::create([
                'visit_uuid' => session('visit_uuid'),
                'url'        => $url,
                'page_type'  => $pageType,
            ]);
            Log::info('PageView created for URL ' . $url . ' and PageView ID ' . $pageView->id);
        }

        // 🔹 Stocker l'ID immédiatement pour sendBeacon
        session(['current_page_view_id' => $pageView->id]);

        return $next($request);
    }

    private function resolvePageType(string $path): string
    {
        if ($path === '/') return 'accueil';
        if (str_starts_with($path, 'detail/appartement/')) return 'appartement_detail';
        if (str_starts_with($path, 'appart-by-property/')) return 'appartement_by_property';
        if ($path === 'all-apparts') return 'appartement_list';
        if (str_starts_with($path, 'reservation/detail/')) return 'reservation_detail';
        if ($path === 'confidentialite') return 'confidentialite';

        return 'other';
    }


    
//     public function terminate($request, $response)
// {
//     // Ignore si pas de session visit
//     if (!session()->has('visit_uuid')) {
//         return;
//     }

//     $url = $request->path();

//     // 🔹 Ignorer les fichiers statiques et le tracking lui-même
//     $ignoredPrefixes = [
//         'storage/', 
//         'track/', 
//         'assets/',
//         'api/', // si tu as des API
//     ];

//     foreach ($ignoredPrefixes as $prefix) {
//         if (str_starts_with($url, $prefix)) {
//             return; // on ne crée pas de PageView
//         }
//     }

//     $pageType = $this->resolvePageType($url);

//     $pageView = PageView::where('visit_uuid', session('visit_uuid'))
//         ->where('url', $url)
//         ->where('page_type', $pageType)
//         ->whereDate('created_at', today())
//         ->first();

//     if (!$pageView) {
//         $pageView = PageView::create([
//             'visit_uuid' => session('visit_uuid'),
//             'url'        => $url,
//             'page_type'  => $pageType,
//         ]);
//         Log::info('PageView created for URL ' . $url.' and PageView ID ' . $pageView->id);
//     }

//     session(['current_page_view_id' => $pageView->id]);
// }


//     private function resolvePageType(string $path): string
//     {
//         if ($path === '/') return 'accueil';
//         if (str_starts_with($path, 'detail/appartement/')) return 'appartement_detail';
//         if (str_starts_with($path, 'appart-by-property/')) return 'appartement_by_property';
//         if ($path === 'all-apparts') return 'appartement_list';
//         if (str_starts_with($path, 'reservation/detail/')) return 'reservation_detail';
//         if ($path === 'confidentialite') return 'confidentialite';

//         return 'other';
//     }
}
