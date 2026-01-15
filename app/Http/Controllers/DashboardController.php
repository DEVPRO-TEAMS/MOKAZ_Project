<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visit;
use Illuminate\Http\Request;
use App\Models\VisitHistorique;
use Illuminate\Support\Facades\DB;

// class DashboardController extends Controller
// {
//     public function getKPIData(Request $request)
//     {
//         $period = $request->get('period', 'month'); // today, week, month, quarter, year
//         $now = Carbon::now();

//         // Définir la période en fonction de la sélection
//         switch($period) {
//             case 'today':
//                 $startDate = $now->startOfDay();
//                 $endDate = $now->endOfDay();
//                 break;
//             case 'week':
//                 $startDate = $now->copy()->startOfWeek();
//                 $endDate = $now->copy()->endOfWeek();
//                 break;
//             case 'month':
//                 $startDate = $now->copy()->startOfMonth();
//                 $endDate = $now->copy()->endOfMonth();
//                 break;
//             case 'quarter':
//                 $startDate = $now->copy()->startOfQuarter();
//                 $endDate = $now->copy()->endOfQuarter();
//                 break;
//             case 'year':
//                 $startDate = $now->copy()->startOfYear();
//                 $endDate = $now->copy()->endOfYear();
//                 break;
//             default:
//                 $startDate = $now->copy()->startOfMonth();
//                 $endDate = $now->copy()->endOfMonth();
//         }

//         // Pour les comparaisons (vs mois dernier)
//         $previousStart = $startDate->copy()->subMonth();
//         $previousEnd = $endDate->copy()->subMonth();

//         // 1. Visiteurs Uniques (basé sur l'IP unique pour la période)
//         $currentUniqueVisitors = Visit::whereBetween('started_at', [$startDate, $endDate])
//             ->distinct('ip_address')
//             ->count();

//         $previousUniqueVisitors = Visit::whereBetween('started_at', [$previousStart, $previousEnd])
//             ->distinct('ip_address')
//             ->count();

//         $uniqueVisitorsTrend = $previousUniqueVisitors > 0 
//             ? (($currentUniqueVisitors - $previousUniqueVisitors) / $previousUniqueVisitors) * 100
//             : 0;

//         // 2. Sessions Totales (tous les visits pour la période)
//         $currentSessions = Visit::whereBetween('started_at', [$startDate, $endDate])->count();
//         $previousSessions = Visit::whereBetween('started_at', [$previousStart, $previousEnd])->count();
//         $sessionsTrend = $previousSessions > 0 
//             ? (($currentSessions - $previousSessions) / $previousSessions) * 100
//             : 0;

//         // 3. Durée Moyenne Session
//         $currentAvgDuration = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
//             ->whereNotNull('duration')
//             ->avg('duration') ?? 0;

//         $previousAvgDuration = VisitHistorique::whereBetween('started_at', [$previousStart, $previousEnd])
//             ->whereNotNull('duration')
//             ->avg('duration') ?? 0;

//         $durationTrend = $previousAvgDuration > 0 
//             ? (($currentAvgDuration - $previousAvgDuration) / $previousAvgDuration) * 100
//             : 0;

//         // Convertir la durée en minutes:secondes
//         $avgDurationFormatted = $this->formatDuration($currentAvgDuration);

//         // 4. Taux de Rebond (visites avec une seule page vue)
//         // Note: Vous devrez adapter cette logique selon votre définition de "rebond"
//         // Exemple: sessions avec duration < 30 secondes
//         $currentBounceSessions = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
//             ->where('duration', '<', 30)
//             ->count();

//         $currentTotalSessions = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])->count();
//         $bounceRate = $currentTotalSessions > 0 
//             ? ($currentBounceSessions / $currentTotalSessions) * 100
//             : 0;

//         // Calcul pour la période précédente
//         $previousBounceSessions = VisitHistorique::whereBetween('started_at', [$previousStart, $previousEnd])
//             ->where('duration', '<', 30)
//             ->count();

//         $previousTotalSessions = VisitHistorique::whereBetween('started_at', [$previousStart, $previousEnd])->count();
//         $previousBounceRate = $previousTotalSessions > 0 
//             ? ($previousBounceSessions / $previousTotalSessions) * 100
//             : 0;

//         $bounceRateTrend = $previousBounceRate > 0 
//             ? ($bounceRate - $previousBounceRate)
//             : 0;

//         // 5. Nouveaux Visiteurs (première visite)
//         $newVisitors = Visit::whereBetween('started_at', [$startDate, $endDate])
//             ->whereNotExists(function ($query) use ($startDate) {
//                 $query->select(DB::raw(1))
//                       ->from('visits as v2')
//                       ->whereRaw('v2.ip_address = visits.ip_address')
//                       ->where('v2.started_at', '<', $startDate);
//             })
//             ->count();

//         $previousNewVisitors = Visit::whereBetween('started_at', [$previousStart, $previousEnd])
//             ->whereNotExists(function ($query) use ($previousStart) {
//                 $query->select(DB::raw(1))
//                       ->from('visits as v2')
//                       ->whereRaw('v2.ip_address = visits.ip_address')
//                       ->where('v2.started_at', '<', $previousStart);
//             })
//             ->count();

//         $newVisitorsTrend = $previousNewVisitors > 0 
//             ? (($newVisitors - $previousNewVisitors) / $previousNewVisitors) * 100
//             : 0;

//         $newVisitorsPercentage = $currentUniqueVisitors > 0 
//             ? ($newVisitors / $currentUniqueVisitors) * 100
//             : 0;

//         // 6. Visiteurs Récurrents
//         $returningVisitors = $currentUniqueVisitors - $newVisitors;
//         $previousReturningVisitors = $previousUniqueVisitors - $previousNewVisitors;

//         $returningVisitorsTrend = $previousReturningVisitors > 0 
//             ? (($returningVisitors - $previousReturningVisitors) / $previousReturningVisitors) * 100
//             : 0;

//         $returningVisitorsPercentage = $currentUniqueVisitors > 0 
//             ? ($returningVisitors / $currentUniqueVisitors) * 100
//             : 0;

//         return response()->json([
//             'kpis' => [
//                 'unique_visitors' => [
//                     'value' => $currentUniqueVisitors,
//                     'trend' => round($uniqueVisitorsTrend, 1),
//                     'trend_direction' => $uniqueVisitorsTrend >= 0 ? 'up' : 'down'
//                 ],
//                 'total_sessions' => [
//                     'value' => $currentSessions,
//                     'trend' => round($sessionsTrend, 1),
//                     'trend_direction' => $sessionsTrend >= 0 ? 'up' : 'down'
//                 ],
//                 'avg_session_duration' => [
//                     'value' => $avgDurationFormatted,
//                     'raw_value' => $currentAvgDuration,
//                     'trend' => round($durationTrend, 1),
//                     'trend_direction' => $durationTrend >= 0 ? 'up' : 'down'
//                 ],
//                 'bounce_rate' => [
//                     'value' => round($bounceRate, 1),
//                     'trend' => round($bounceRateTrend, 1),
//                     'trend_direction' => $bounceRateTrend < 0 ? 'up' : 'down' // Note: pour bounce rate, la baisse est positive
//                 ],
//                 'new_visitors' => [
//                     'value' => $newVisitors,
//                     'trend' => round($newVisitorsTrend, 1),
//                     'percentage' => round($newVisitorsPercentage, 1),
//                     'trend_direction' => $newVisitorsTrend >= 0 ? 'up' : 'down'
//                 ],
//                 'returning_visitors' => [
//                     'value' => $returningVisitors,
//                     'trend' => round($returningVisitorsTrend, 1),
//                     'percentage' => round($returningVisitorsPercentage, 1),
//                     'trend_direction' => $returningVisitorsTrend >= 0 ? 'up' : 'down'
//                 ]
//             ],
//             'period' => $period,
//             'period_dates' => [
//                 'start' => $startDate->format('Y-m-d'),
//                 'end' => $endDate->format('Y-m-d')
//             ]
//         ]);
//     }

//     public function getTrafficChartData(Request $request)
//     {
//         $months = 12; // Nombre de mois à afficher
//         $data = [];

//         for ($i = $months - 1; $i >= 0; $i--) {
//             $month = Carbon::now()->subMonths($i);
//             $startDate = $month->copy()->startOfMonth();
//             $endDate = $month->copy()->endOfMonth();

//             // Visiteurs uniques par mois
//             $uniqueVisitors = Visit::whereBetween('started_at', [$startDate, $endDate])
//                 ->distinct('ip_address')
//                 ->count();

//             // Sessions totales par mois
//             $totalSessions = Visit::whereBetween('started_at', [$startDate, $endDate])
//                 ->count();

//             $data[] = [
//                 'month' => $month->format('M'),
//                 'year' => $month->format('Y'),
//                 'unique_visitors' => $uniqueVisitors,
//                 'total_sessions' => $totalSessions
//             ];
//         }

//         return response()->json([
//             'chart_data' => $data,
//             'labels' => array_column($data, 'month'),
//             'unique_visitors_data' => array_column($data, 'unique_visitors'),
//             'total_sessions_data' => array_column($data, 'total_sessions')
//         ]);
//     }

//     public function getSourcesData(Request $request)
//     {
//         $period = $request->get('period', 'month');
//         $now = Carbon::now();

//         switch($period) {
//             case 'today':
//                 $startDate = $now->startOfDay();
//                 break;
//             case 'week':
//                 $startDate = $now->copy()->startOfWeek();
//                 break;
//             case 'month':
//                 $startDate = $now->copy()->startOfMonth();
//                 break;
//             case 'quarter':
//                 $startDate = $now->copy()->startOfQuarter();
//                 break;
//             case 'year':
//                 $startDate = $now->copy()->startOfYear();
//                 break;
//             default:
//                 $startDate = $now->copy()->startOfMonth();
//         }

//         $sources = VisitHistorique::where('started_at', '>=', $startDate)
//             ->select('source', DB::raw('COUNT(*) as count'))
//             ->groupBy('source')
//             ->orderBy('count', 'desc')
//             ->get();

//         $total = $sources->sum('count');

//         $formattedData = $sources->map(function($item) use ($total) {
//             return [
//                 'source' => $this->formatSourceName($item->source),
//                 'count' => $item->count,
//                 'percentage' => $total > 0 ? round(($item->count / $total) * 100, 1) : 0
//             ];
//         });

//         return response()->json([
//             'sources' => $formattedData,
//             'total' => $total
//         ]);
//     }

//     public function getTopCities(Request $request)
//     {
//         $period = $request->get('period', 'month');
//         $now = Carbon::now();

//         switch($period) {
//             case 'today':
//                 $startDate = $now->startOfDay();
//                 break;
//             case 'week':
//                 $startDate = $now->copy()->startOfWeek();
//                 break;
//             case 'month':
//                 $startDate = $now->copy()->startOfMonth();
//                 break;
//             case 'quarter':
//                 $startDate = $now->copy()->startOfQuarter();
//                 break;
//             case 'year':
//                 $startDate = $now->copy()->startOfYear();
//                 break;
//             default:
//                 $startDate = $now->copy()->startOfMonth();
//         }

//         $cities = VisitHistorique::where('started_at', '>=', $startDate)
//             ->whereNotNull('city')
//             ->select('city', DB::raw('COUNT(*) as count'))
//             ->groupBy('city')
//             ->orderBy('count', 'desc')
//             ->limit(6)
//             ->get();

//         return response()->json([
//             'cities' => $cities
//         ]);
//     }

//     private function formatDuration($seconds)
//     {
//         if (!$seconds) return '0s';

//         $minutes = floor($seconds / 60);
//         $remainingSeconds = $seconds % 60;

//         if ($minutes > 0) {
//             return sprintf('%dm %ds', $minutes, $remainingSeconds);
//         }

//         return sprintf('%ds', $remainingSeconds);
//     }

//     private function formatSourceName($source)
//     {
//         $sources = [
//             'direct' => 'Direct',
//             'seo' => 'SEO',
//             'organic' => 'Organique',
//             'social' => 'Réseaux Sociaux',
//             'ads' => 'Payant (CPC)',
//             'email' => 'Email',
//             'referral' => 'Référence'
//         ];

//         return $sources[$source] ?? ucfirst($source);
//     }
// }
class DashboardController extends Controller
{
    public function getKPIData(Request $request)
    {
        $period = $request->get('period', 'month'); // today, week, month, quarter, year
        $now = Carbon::now();

        // Définir la période actuelle
        switch ($period) {
            case 'today':
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
                $previousStart = $now->copy()->subDay()->startOfDay();
                $previousEnd = $now->copy()->subDay()->endOfDay();
                break;
            case 'week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                $previousStart = $now->copy()->subWeek()->startOfWeek();
                $previousEnd = $now->copy()->subWeek()->endOfWeek();
                break;
            case 'month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $previousStart = $now->copy()->subMonth()->startOfMonth();
                $previousEnd = $now->copy()->subMonth()->endOfMonth();
                break;
            case 'quarter':
                $startDate = $now->copy()->startOfQuarter();
                $endDate = $now->copy()->endOfQuarter();
                $previousStart = $now->copy()->subQuarter()->startOfQuarter();
                $previousEnd = $now->copy()->subQuarter()->endOfQuarter();
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                $previousStart = $now->copy()->subYear()->startOfYear();
                $previousEnd = $now->copy()->subYear()->endOfYear();
                break;
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $previousStart = $now->copy()->subMonth()->startOfMonth();
                $previousEnd = $now->copy()->subMonth()->endOfMonth();
        }

        // 1. Visiteurs Uniques
        $currentUniqueVisitors = Visit::whereBetween('started_at', [$startDate, $endDate])
            ->distinct('ip_address')
            ->count();

        $previousUniqueVisitors = Visit::whereBetween('started_at', [$previousStart, $previousEnd])
            ->distinct('ip_address')
            ->count();

        $uniqueVisitorsTrend = $previousUniqueVisitors > 0
            ? (($currentUniqueVisitors - $previousUniqueVisitors) / $previousUniqueVisitors) * 100
            : ($currentUniqueVisitors > 0 ? 100 : 0);

        // 2. Sessions Totales
        $currentSessions = Visit::whereBetween('started_at', [$startDate, $endDate])->count();
        $previousSessions = Visit::whereBetween('started_at', [$previousStart, $previousEnd])->count();
        $sessionsTrend = $previousSessions > 0
            ? (($currentSessions - $previousSessions) / $previousSessions) * 100
            : ($currentSessions > 0 ? 100 : 0);

        // 3. Durée Moyenne Session
        $currentAvgDuration = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('duration')
            ->avg('duration') ?? 0;

        $previousAvgDuration = VisitHistorique::whereBetween('started_at', [$previousStart, $previousEnd])
            ->whereNotNull('duration')
            ->avg('duration') ?? 0;

        $durationTrend = $previousAvgDuration > 0
            ? (($currentAvgDuration - $previousAvgDuration) / $previousAvgDuration) * 100
            : ($currentAvgDuration > 0 ? 100 : 0);

        // Convertir la durée en minutes:secondes
        $avgDurationFormatted = $this->formatDuration($currentAvgDuration);

        // 4. Taux de Rebond
        $currentBounceSessions = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
            ->where('duration', '<', 30)
            ->count();

        $currentTotalSessions = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])->count();
        $bounceRate = $currentTotalSessions > 0
            ? ($currentBounceSessions / $currentTotalSessions) * 100
            : 0;

        // Calcul pour la période précédente
        $previousBounceSessions = VisitHistorique::whereBetween('started_at', [$previousStart, $previousEnd])
            ->where('duration', '<', 30)
            ->count();

        $previousTotalSessions = VisitHistorique::whereBetween('started_at', [$previousStart, $previousEnd])->count();
        $previousBounceRate = $previousTotalSessions > 0
            ? ($previousBounceSessions / $previousTotalSessions) * 100
            : 0;

        $bounceRateTrend = $previousBounceRate > 0
            ? (($bounceRate - $previousBounceRate) / $previousBounceRate) * 100
            : ($bounceRate > 0 ? 100 : 0);

        // 5. Nouveaux Visiteurs
        $newVisitors = Visit::whereBetween('started_at', [$startDate, $endDate])
            ->whereNotExists(function ($query) use ($startDate) {
                $query->select(DB::raw(1))
                    ->from('visits as v2')
                    ->whereRaw('v2.ip_address = visits.ip_address')
                    ->where('v2.started_at', '<', $startDate);
            })
            ->count();

        $previousNewVisitors = Visit::whereBetween('started_at', [$previousStart, $previousEnd])
            ->whereNotExists(function ($query) use ($previousStart) {
                $query->select(DB::raw(1))
                    ->from('visits as v2')
                    ->whereRaw('v2.ip_address = visits.ip_address')
                    ->where('v2.started_at', '<', $previousStart);
            })
            ->count();

        $newVisitorsTrend = $previousNewVisitors > 0
            ? (($newVisitors - $previousNewVisitors) / $previousNewVisitors) * 100
            : ($newVisitors > 0 ? 100 : 0);

        $newVisitorsPercentage = $currentUniqueVisitors > 0
            ? ($newVisitors / $currentUniqueVisitors) * 100
            : 0;

        // 6. Visiteurs Récurrents
        $returningVisitors = $currentUniqueVisitors - $newVisitors;
        $previousReturningVisitors = $previousUniqueVisitors - $previousNewVisitors;

        $returningVisitorsTrend = $previousReturningVisitors > 0
            ? (($returningVisitors - $previousReturningVisitors) / $previousReturningVisitors) * 100
            : ($returningVisitors > 0 ? 100 : 0);

        $returningVisitorsPercentage = $currentUniqueVisitors > 0
            ? ($returningVisitors / $currentUniqueVisitors) * 100
            : 0;

        // Texte de comparaison adapté à la période
        $comparisonText = $this->getComparisonText($period);

        return response()->json([
            'kpis' => [
                'unique_visitors' => [
                    'value' => $currentUniqueVisitors,
                    'trend' => round($uniqueVisitorsTrend, 1),
                    'trend_direction' => $uniqueVisitorsTrend >= 0 ? 'up' : 'down'
                ],
                'total_sessions' => [
                    'value' => $currentSessions,
                    'trend' => round($sessionsTrend, 1),
                    'trend_direction' => $sessionsTrend >= 0 ? 'up' : 'down'
                ],
                'avg_session_duration' => [
                    'value' => $avgDurationFormatted,
                    'raw_value' => $currentAvgDuration,
                    'trend' => round($durationTrend, 1),
                    'trend_direction' => $durationTrend >= 0 ? 'up' : 'down'
                ],
                'bounce_rate' => [
                    'value' => round($bounceRate, 1),
                    'trend' => round($bounceRateTrend, 1),
                    'trend_direction' => $bounceRateTrend < 0 ? 'up' : 'down'
                ],
                'new_visitors' => [
                    'value' => $newVisitors,
                    'trend' => round($newVisitorsTrend, 1),
                    'percentage' => round($newVisitorsPercentage, 1),
                    'trend_direction' => $newVisitorsTrend >= 0 ? 'up' : 'down'
                ],
                'returning_visitors' => [
                    'value' => $returningVisitors,
                    'trend' => round($returningVisitorsTrend, 1),
                    'percentage' => round($returningVisitorsPercentage, 1),
                    'trend_direction' => $returningVisitorsTrend >= 0 ? 'up' : 'down'
                ]
            ],
            'period' => $period,
            'comparison_text' => $comparisonText,
            'period_dates' => [
                'current' => [
                    'start' => $startDate->format('Y-m-d H:i:s'),
                    'end' => $endDate->format('Y-m-d H:i:s')
                ],
                'previous' => [
                    'start' => $previousStart->format('Y-m-d H:i:s'),
                    'end' => $previousEnd->format('Y-m-d H:i:s')
                ]
            ]
        ]);
    }

    public function getTrafficChartData(Request $request)
    {
        $period = $request->get('period', 'month');
        $now = Carbon::now();

        // Déterminer le nombre de points et l'intervalle selon la période
        switch ($period) {
            case 'today':
                $dataPoints = 24; // 24 heures
                $interval = 'hour';
                break;
            case 'week':
                $dataPoints = 7; // 7 jours
                $interval = 'day';
                break;
            case 'month':
                $dataPoints = 30; // 30 jours
                $interval = 'day';
                break;
            case 'quarter':
                $dataPoints = 13; // 13 semaines
                $interval = 'week';
                break;
            case 'year':
                $dataPoints = 12; // 12 mois
                $interval = 'month';
                break;
            default:
                $dataPoints = 12;
                $interval = 'month';
        }

        $data = [];
        $labels = [];

        for ($i = $dataPoints - 1; $i >= 0; $i--) {
            if ($interval === 'hour') {
                $pointDate = $now->copy()->subHours($i);
                $startDate = $pointDate->copy()->startOfHour();
                $endDate = $pointDate->copy()->endOfHour();
                $label = $pointDate->format('H:00');
            } elseif ($interval === 'day') {
                $pointDate = $now->copy()->subDays($i);
                $startDate = $pointDate->copy()->startOfDay();
                $endDate = $pointDate->copy()->endOfDay();
                $label = $pointDate->format('d/m');
            } elseif ($interval === 'week') {
                $pointDate = $now->copy()->subWeeks($i);
                $startDate = $pointDate->copy()->startOfWeek();
                $endDate = $pointDate->copy()->endOfWeek();
                $label = 'S' . $pointDate->weekOfYear;
            } elseif ($interval === 'month') {
                $pointDate = $now->copy()->subMonths($i);
                $startDate = $pointDate->copy()->startOfMonth();
                $endDate = $pointDate->copy()->endOfMonth();
                $label = $pointDate->format('M');
            }

            // Visiteurs uniques
            $uniqueVisitors = Visit::whereBetween('started_at', [$startDate, $endDate])
                ->distinct('ip_address')
                ->count();

            // Sessions totales
            $totalSessions = Visit::whereBetween('started_at', [$startDate, $endDate])
                ->count();

            $data[] = [
                'label' => $label,
                'unique_visitors' => $uniqueVisitors,
                'total_sessions' => $totalSessions
            ];

            $labels[] = $label;
        }

        return response()->json([
            'chart_data' => $data,
            'labels' => $labels,
            'unique_visitors_data' => array_column($data, 'unique_visitors'),
            'total_sessions_data' => array_column($data, 'total_sessions'),
            'interval' => $interval,
            'period' => $period
        ]);
    }

    public function getSourcesData(Request $request)
    {
        $period = $request->get('period', 'month');
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = $now->startOfDay();
                $endDate = $now->endOfDay();
                break;
            case 'week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'quarter':
                $startDate = $now->copy()->startOfQuarter();
                $endDate = $now->copy()->endOfQuarter();
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
        }

        $sources = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
            ->select('source', DB::raw('COUNT(*) as count'))
            ->groupBy('source')
            ->orderBy('count', 'desc')
            ->get();

        $total = $sources->sum('count');

        $formattedData = $sources->map(function ($item) use ($total) {
            return [
                'source' => $this->formatSourceName($item->source),
                'count' => $item->count,
                'percentage' => $total > 0 ? round(($item->count / $total) * 100, 1) : 0
            ];
        });

        return response()->json([
            'sources' => $formattedData,
            'total' => $total,
            'period' => $period,
            'period_dates' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d')
            ]
        ]);
    }

    public function getTopCities(Request $request)
    {
        $period = $request->get('period', 'month');
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = $now->startOfDay();
                $endDate = $now->endOfDay();
                break;
            case 'week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'quarter':
                $startDate = $now->copy()->startOfQuarter();
                $endDate = $now->copy()->endOfQuarter();
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
        }

        $cities = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('city')
            ->select('city', DB::raw('COUNT(*) as count'))
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(6)
            ->get();

        return response()->json([
            'cities' => $cities,
            'period' => $period,
            'period_dates' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d')
            ]
        ]);
    }

    private function formatDuration($seconds)
    {
        if (!$seconds) return '0s';

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes > 0) {
            return sprintf('%dm %ds', $minutes, $remainingSeconds);
        }

        return sprintf('%ds', $remainingSeconds);
    }

    private function formatSourceName($source)
    {
        $sources = [
            'direct' => 'Direct',
            'seo' => 'SEO',
            'organic' => 'Organique',
            'social' => 'Réseaux Sociaux',
            'ads' => 'Payant (CPC)',
            'email' => 'Email',
            'referral' => 'Référence'
        ];

        return $sources[$source] ?? ucfirst($source);
    }

    private function getComparisonText($period)
    {
        $comparisons = [
            'today' => 'vs hier',
            'week' => 'vs semaine dernière',
            'month' => 'vs mois dernier',
            'quarter' => 'vs trimestre dernier',
            'year' => 'vs année dernière'
        ];

        return $comparisons[$period] ?? 'vs période précédente';
    }



    public function getGeographicData(Request $request)
    {
        $period = $request->get('period', 'month');
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = $now->startOfDay();
                $endDate = $now->endOfDay();
                break;
            case 'week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'quarter':
                $startDate = $now->copy()->startOfQuarter();
                $endDate = $now->copy()->endOfQuarter();
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
        }

        // Total des visites pour la période
        $totalVisits = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])->count();

        // Données des pays - Top 10 mondial avec pourcentages
        $countries = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('country')
            ->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) use ($totalVisits) {
                $percentage = $totalVisits > 0 ? round(($item->count / $totalVisits) * 100, 2) : 0;

                return [
                    'country' => $item->country,
                    'country_code' => $this->getCountryCode($item->country),
                    'count' => $item->count,
                    'percentage' => $percentage,
                    'flag' => $this->getCountryFlag($item->country)
                ];
            });

        // Pourcentages mondiaux par continent
        $continentsData = $this->calculateContinentsPercentages($startDate, $endDate, $totalVisits);

        // Données des villes avec coordonnées et pourcentages
        $citiesWithCoords = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('city')
            ->whereNotNull('coordornneGPS')
            ->where('coordornneGPS', '!=', '')
            ->select('city', 'country', 'coordornneGPS', DB::raw('COUNT(*) as count'))
            ->groupBy('city', 'country', 'coordornneGPS')
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($item) use ($totalVisits) {
                $coords = explode(',', $item->coordornneGPS);
                $percentage = $totalVisits > 0 ? round(($item->count / $totalVisits) * 100, 2) : 0;

                return [
                    'city' => $item->city,
                    'country' => $item->country,
                    'latitude' => isset($coords[0]) ? (float)trim($coords[0]) : null,
                    'longitude' => isset($coords[1]) ? (float)trim($coords[1]) : null,
                    'count' => $item->count,
                    'percentage' => $percentage
                ];
            })
            ->filter(function ($item) {
                return !is_null($item['latitude']) && !is_null($item['longitude']);
            });

        // Statistiques globales
        $topCountry = $countries->isNotEmpty() ? $countries[0] : null;
        $topCity = $citiesWithCoords->isNotEmpty() ? $citiesWithCoords[0] : null;

        // Calculer la somme des pourcentages des 10 premiers pays
        $topCountriesPercentage = $countries->sum('percentage');

        return response()->json([
            'countries' => $countries,
            'cities' => $citiesWithCoords,
            'continents' => $continentsData,
            'statistics' => [
                'total_visits' => $totalVisits,
                'global_distribution' => [
                    'top_country' => $topCountry ? [
                        'name' => $topCountry['country'],
                        'visits' => $topCountry['count'],
                        'percentage' => $topCountry['percentage'],
                        'flag' => $topCountry['flag']
                    ] : null,
                    'top_city' => $topCity ? [
                        'name' => $topCity['city'],
                        'country' => $topCity['country'],
                        'visits' => $topCity['count'],
                        'percentage' => $topCity['percentage']
                    ] : null,
                    'top_10_countries_percentage' => $topCountriesPercentage,
                    'countries_count' => VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
                        ->whereNotNull('country')
                        ->distinct('country')
                        ->count('country'),
                    'cities_count' => VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
                        ->whereNotNull('city')
                        ->distinct('city')
                        ->count('city'),
                    'remaining_countries_percentage' => max(0, 100 - $topCountriesPercentage)
                ],
                'africa_distribution' => [
                    'total_percentage' => $continentsData['africa']['percentage'] ?? 0,
                    'west_africa' => [
                        'percentage' => $this->calculateRegionPercentage($startDate, $endDate, $totalVisits, 'west'),
                        'countries' => $this->getTopCountriesByRegion($startDate, $endDate, 'west', 3)
                    ],
                    'north_africa' => [
                        'percentage' => $this->calculateRegionPercentage($startDate, $endDate, $totalVisits, 'north'),
                        'countries' => $this->getTopCountriesByRegion($startDate, $endDate, 'north', 3)
                    ],
                    'central_africa' => [
                        'percentage' => $this->calculateRegionPercentage($startDate, $endDate, $totalVisits, 'central'),
                        'countries' => $this->getTopCountriesByRegion($startDate, $endDate, 'central', 3)
                    ],
                    'east_africa' => [
                        'percentage' => $this->calculateRegionPercentage($startDate, $endDate, $totalVisits, 'east'),
                        'countries' => $this->getTopCountriesByRegion($startDate, $endDate, 'east', 3)
                    ],
                    'south_africa' => [
                        'percentage' => $this->calculateRegionPercentage($startDate, $endDate, $totalVisits, 'south'),
                        'countries' => $this->getTopCountriesByRegion($startDate, $endDate, 'south', 3)
                    ]
                ]
            ],
            'period' => $period,
            'period_dates' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d')
            ]
        ]);
    }

    private function calculateContinentsPercentages($startDate, $endDate, $totalVisits)
    {
        // Définition des pays par continent (liste exhaustive)
        $continents = [
            'africa' => [
                'name' => 'Afrique',
                'color' => '#FF6B35',
                'icon' => 'fa-globe-africa',
                'countries' => $this->getAfricanCountries()
            ],
            'europe' => [
                'name' => 'Europe',
                'color' => '#004E89',
                'icon' => 'fa-globe-europe',
                'countries' => $this->getEuropeanCountries()
            ],
            'north_america' => [
                'name' => 'Amérique du Nord',
                'color' => '#06D6A0',
                'icon' => 'fa-globe-americas',
                'countries' => $this->getNorthAmericanCountries()
            ],
            'south_america' => [
                'name' => 'Amérique du Sud',
                'color' => '#FFB627',
                'icon' => 'fa-globe-americas',
                'countries' => $this->getSouthAmericanCountries()
            ],
            'asia' => [
                'name' => 'Asie',
                'color' => '#667eea',
                'icon' => 'fa-globe-asia',
                'countries' => $this->getAsianCountries()
            ],
            'oceania' => [
                'name' => 'Océanie',
                'color' => '#764ba2',
                'icon' => 'fa-globe',
                'countries' => $this->getOceanianCountries()
            ]
        ];

        $result = [];
        $totalContinentsVisits = 0;

        foreach ($continents as $continentKey => $continentData) {
            $visits = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
                ->whereIn('country', $continentData['countries'])
                ->count();

            $percentage = $totalVisits > 0 ? round(($visits / $totalVisits) * 100, 2) : 0;
            $totalContinentsVisits += $visits;

            $result[$continentKey] = [
                'name' => $continentData['name'],
                'color' => $continentData['color'],
                'icon' => $continentData['icon'],
                'visits' => $visits,
                'percentage' => $percentage
            ];
        }

        // Ajouter "Autres" pour les pays non classés
        $otherVisits = $totalVisits - $totalContinentsVisits;
        $otherPercentage = $totalVisits > 0 ? round(($otherVisits / $totalVisits) * 100, 2) : 0;

        if ($otherPercentage > 0) {
            $result['other'] = [
                'name' => 'Autres',
                'color' => '#999',
                'icon' => 'fa-globe',
                'visits' => $otherVisits,
                'percentage' => $otherPercentage
            ];
        }

        return $result;
    }

    private function getAfricanCountries()
    {
        return [
            // Afrique de l'Ouest
            'Côte d\'Ivoire',
            'Sénégal',
            'Mali',
            'Burkina Faso',
            'Guinée',
            'Niger',
            'Bénin',
            'Togo',
            'Ghana',
            'Nigéria',
            'Mauritanie',
            'Guinée-Bissau',
            'Sierra Leone',
            'Liberia',
            'Gambie',
            'Cabo Verde',
            // Afrique du Nord
            'Maroc',
            'Tunisie',
            'Algérie',
            'Égypte',
            'Libye',
            'Soudan',
            'Mauritanie',
            // Afrique Centrale
            'Cameroun',
            'RDC',
            'Congo',
            'Gabon',
            'Guinée équatoriale',
            'République centrafricaine',
            'Tchad',
            'São Tomé et Príncipe',
            // Afrique de l'Est
            'Kenya',
            'Éthiopie',
            'Tanzanie',
            'Ouganda',
            'Rwanda',
            'Burundi',
            'Somalie',
            'Djibouti',
            'Érythrée',
            'Soudan du Sud',
            // Afrique Australe
            'Afrique du Sud',
            'Namibie',
            'Botswana',
            'Zimbabwe',
            'Zambie',
            'Malawi',
            'Mozambique',
            'Angola',
            'Madagascar',
            'Maurice',
            'Seychelles',
            'Comores',
            'Eswatini',
            'Lesotho'
        ];
    }

    private function getEuropeanCountries()
    {
        return [
            'France',
            'Belgique',
            'Suisse',
            'Royaume-Uni',
            'United Kingdom',
            'UK',
            'Allemagne',
            'Germany',
            'Espagne',
            'Spain',
            'Italie',
            'Italy',
            'Portugal',
            'Pays-Bas',
            'Netherlands',
            'Luxembourg',
            'Autriche',
            'Austria',
            'Suède',
            'Sweden',
            'Norvège',
            'Norway',
            'Danemark',
            'Denmark',
            'Finlande',
            'Finland',
            'Irlande',
            'Ireland',
            'Pologne',
            'Poland',
            'République Tchèque',
            'Czech Republic',
            'Slovaquie',
            'Slovakia',
            'Hongrie',
            'Hungary',
            'Roumanie',
            'Romania',
            'Bulgarie',
            'Bulgaria',
            'Grèce',
            'Greece',
            'Turquie',
            'Turkey',
            'Ukraine',
            'Russia',
            'Russie'
        ];
    }

    private function getNorthAmericanCountries()
    {
        return [
            'Canada',
            'États-Unis',
            'USA',
            'United States',
            'US',
            'Mexique',
            'Mexico'
        ];
    }

    private function getSouthAmericanCountries()
    {
        return [
            'Brésil',
            'Brazil',
            'Argentine',
            'Argentina',
            'Colombie',
            'Colombia',
            'Pérou',
            'Peru',
            'Chili',
            'Chile',
            'Venezuela',
            'Équateur',
            'Ecuador',
            'Bolivie',
            'Bolivia',
            'Paraguay',
            'Uruguay',
            'Guyane',
            'Suriname'
        ];
    }

    private function getAsianCountries()
    {
        return [
            'Chine',
            'China',
            'Japon',
            'Japan',
            'Inde',
            'India',
            'Corée du Sud',
            'South Korea',
            'Corée du Nord',
            'North Korea',
            'Viêt Nam',
            'Vietnam',
            'Thaïlande',
            'Thailand',
            'Indonésie',
            'Indonesia',
            'Malaisie',
            'Malaysia',
            'Philippines',
            'Singapour',
            'Singapore',
            'Taiwan',
            'Hong Kong',
            'Macao',
            'Pakistan',
            'Bangladesh',
            'Sri Lanka',
            'Népal',
            'Nepal',
            'Bhoutan',
            'Bhutan',
            'Maldives',
            'Afghanistan',
            'Iran',
            'Irak',
            'Iraq',
            'Arabie saoudite',
            'Saudi Arabia',
            'Émirats arabes unis',
            'United Arab Emirates',
            'UAE',
            'Qatar',
            'Koweït',
            'Kuwait',
            'Oman',
            'Yémen',
            'Yemen',
            'Syrie',
            'Syria',
            'Liban',
            'Lebanon',
            'Jordanie',
            'Jordan',
            'Israël',
            'Israel',
            'Palestine'
        ];
    }

    private function getOceanianCountries()
    {
        return [
            'Australie',
            'Australia',
            'Nouvelle-Zélande',
            'New Zealand',
            'Papouasie-Nouvelle-Guinée',
            'Papua New Guinea',
            'Fidji',
            'Fiji',
            'Samoa',
            'Tonga',
            'Vanuatu'
        ];
    }

    private function calculateRegionPercentage($startDate, $endDate, $totalVisits, $region)
    {
        $regions = [
            'west' => [
                'Côte d\'Ivoire',
                'Sénégal',
                'Mali',
                'Burkina Faso',
                'Guinée',
                'Niger',
                'Bénin',
                'Togo',
                'Ghana',
                'Nigéria',
                'Mauritanie',
                'Guinée-Bissau',
                'Sierra Leone',
                'Liberia',
                'Gambie',
                'Cabo Verde'
            ],
            'north' => ['Maroc', 'Tunisie', 'Algérie', 'Égypte', 'Libye', 'Soudan', 'Mauritanie'],
            'central' => ['Cameroun', 'RDC', 'Congo', 'Gabon', 'Guinée équatoriale', 'République centrafricaine', 'Tchad', 'São Tomé et Príncipe'],
            'east' => ['Kenya', 'Éthiopie', 'Tanzanie', 'Ouganda', 'Rwanda', 'Burundi', 'Somalie', 'Djibouti', 'Érythrée', 'Soudan du Sud'],
            'south' => [
                'Afrique du Sud',
                'Namibie',
                'Botswana',
                'Zimbabwe',
                'Zambie',
                'Malawi',
                'Mozambique',
                'Angola',
                'Madagascar',
                'Maurice',
                'Seychelles',
                'Comores',
                'Eswatini',
                'Lesotho'
            ]
        ];

        if (!isset($regions[$region])) {
            return 0;
        }

        $visits = VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
            ->whereIn('country', $regions[$region])
            ->count();

        return $totalVisits > 0 ? round(($visits / $totalVisits) * 100, 2) : 0;
    }

    private function getTopCountriesByRegion($startDate, $endDate, $region, $limit = 3)
    {
        $regions = [
            'west' => [
                'Côte d\'Ivoire',
                'Sénégal',
                'Mali',
                'Burkina Faso',
                'Guinée',
                'Niger',
                'Bénin',
                'Togo',
                'Ghana',
                'Nigéria',
                'Mauritanie',
                'Guinée-Bissau',
                'Sierra Leone',
                'Liberia',
                'Gambie',
                'Cabo Verde'
            ],
            'north' => ['Maroc', 'Tunisie', 'Algérie', 'Égypte', 'Libye', 'Soudan', 'Mauritanie'],
            'central' => ['Cameroun', 'RDC', 'Congo', 'Gabon', 'Guinée équatoriale', 'République centrafricaine', 'Tchad', 'São Tomé et Príncipe'],
            'east' => ['Kenya', 'Éthiopie', 'Tanzanie', 'Ouganda', 'Rwanda', 'Burundi', 'Somalie', 'Djibouti', 'Érythrée', 'Soudan du Sud'],
            'south' => [
                'Afrique du Sud',
                'Namibie',
                'Botswana',
                'Zimbabwe',
                'Zambie',
                'Malawi',
                'Mozambique',
                'Angola',
                'Madagascar',
                'Maurice',
                'Seychelles',
                'Comores',
                'Eswatini',
                'Lesotho'
            ]
        ];

        if (!isset($regions[$region])) {
            return [];
        }

        return VisitHistorique::whereBetween('started_at', [$startDate, $endDate])
            ->whereIn('country', $regions[$region])
            ->whereNotNull('country')
            ->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'country' => $item->country,
                    'count' => $item->count,
                    'flag' => $this->getCountryFlag($item->country),
                    'percentage' => 0 // Calculé côté client si nécessaire
                ];
            })
            ->toArray();
    }

    private function getCountryCode($countryName)
    {
        $countryCodes = [
            'Côte d\'Ivoire' => 'CI',
            'France' => 'FR',
            'Sénégal' => 'SN',
            'Mali' => 'ML',
            'Burkina Faso' => 'BF',
            'Guinée' => 'GN',
            'Niger' => 'NE',
            'Bénin' => 'BJ',
            'Togo' => 'TG',
            'Ghana' => 'GH',
            'Nigéria' => 'NG',
            'Cameroun' => 'CM',
            'RDC' => 'CD',
            'Congo' => 'CG',
            'Belgique' => 'BE',
            'Suisse' => 'CH',
            'Canada' => 'CA',
            'États-Unis' => 'US',
            'USA' => 'US',
            'United States' => 'US',
            'Royaume-Uni' => 'GB',
            'United Kingdom' => 'GB',
            'UK' => 'GB',
            'Allemagne' => 'DE',
            'Germany' => 'DE',
            'Espagne' => 'ES',
            'Spain' => 'ES',
            'Italie' => 'IT',
            'Italy' => 'IT',
            'Portugal' => 'PT',
            'Pays-Bas' => 'NL',
            'Netherlands' => 'NL',
            'Maroc' => 'MA',
            'Tunisie' => 'TN',
            'Algérie' => 'DZ',
            'Égypte' => 'EG',
            'Afrique du Sud' => 'ZA',
            'South Africa' => 'ZA',
            'Kenya' => 'KE',
            'Éthiopie' => 'ET',
            'Australie' => 'AU',
            'Australia' => 'AU',
            'Japon' => 'JP',
            'Japan' => 'JP',
            'Chine' => 'CN',
            'China' => 'CN',
            'Inde' => 'IN',
            'India' => 'IN',
            'Brésil' => 'BR',
            'Brazil' => 'BR',
            'Mexique' => 'MX',
            'Mexico' => 'MX',
            'Argentine' => 'AR',
            'Argentina' => 'AR'
        ];

        return $countryCodes[$countryName] ?? strtoupper(substr($countryName, 0, 2));
    }

    private function getCountryFlag($countryName)
    {
        $countryFlags = [
            'Côte d\'Ivoire' => '🇨🇮',
            'France' => '🇫🇷',
            'Sénégal' => '🇸🇳',
            'Mali' => '🇲🇱',
            'Burkina Faso' => '🇧🇫',
            'Guinée' => '🇬🇳',
            'Niger' => '🇳🇪',
            'Bénin' => '🇧🇯',
            'Togo' => '🇹🇬',
            'Ghana' => '🇬🇭',
            'Nigéria' => '🇳🇬',
            'Cameroun' => '🇨🇲',
            'RDC' => '🇨🇩',
            'Congo' => '🇨🇬',
            'Belgique' => '🇧🇪',
            'Suisse' => '🇨🇭',
            'Canada' => '🇨🇦',
            'États-Unis' => '🇺🇸',
            'USA' => '🇺🇸',
            'United States' => '🇺🇸',
            'Royaume-Uni' => '🇬🇧',
            'United Kingdom' => '🇬🇧',
            'UK' => '🇬🇧',
            'Allemagne' => '🇩🇪',
            'Germany' => '🇩🇪',
            'Espagne' => '🇪🇸',
            'Spain' => '🇪🇸',
            'Italie' => '🇮🇹',
            'Italy' => '🇮🇹',
            'Portugal' => '🇵🇹',
            'Pays-Bas' => '🇳🇱',
            'Netherlands' => '🇳🇱',
            'Maroc' => '🇲🇦',
            'Tunisie' => '🇹🇳',
            'Algérie' => '🇩🇿',
            'Égypte' => '🇪🇬',
            'Afrique du Sud' => '🇿🇦',
            'South Africa' => '🇿🇦',
            'Kenya' => '🇰🇪',
            'Éthiopie' => '🇪🇹',
            'Australie' => '🇦🇺',
            'Australia' => '🇦🇺',
            'Japon' => '🇯🇵',
            'Japan' => '🇯🇵',
            'Chine' => '🇨🇳',
            'China' => '🇨🇳',
            'Inde' => '🇮🇳',
            'India' => '🇮🇳',
            'Brésil' => '🇧🇷',
            'Brazil' => '🇧🇷',
            'Mexique' => '🇲🇽',
            'Mexico' => '🇲🇽',
            'Argentine' => '🇦🇷',
            'Argentina' => '🇦🇷'
        ];

        return $countryFlags[$countryName] ?? '🏳️';
    }
}
