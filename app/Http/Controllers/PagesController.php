<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Property;
use App\Models\Appartement;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class PagesController extends Controller
{
    public function index()
    {
        $apparts = Appartement::where('etat', 'actif')->get();
        // $bestApparts = Appartement::where('etat', 'actif')->take(3)->with('reservations')->orderBy('created_at', 'desc')->get();
        $bestApparts = Appartement::withCount('reservations')
        ->where('etat', 'actif')
        ->where('nbr_available', '>', 0)
        ->orderByDesc('reservations_count')
        ->take(3)
        ->with('tarifications') // si tu as une relation tarifications() dans le modèle Appartement
        ->get();
        // dd($bestApparts);
        return view('welcome', compact('apparts', 'bestApparts'));
    }
    // Récupérer tous les propriétés de lequel il y a des appartements disponibles nbr_available>0
    // $properties = Property::where('etat', 'pending')
    // ->whereHas('apartements', function ($query) {
    //     $query->where('nbr_available', '>', 0);
    // })
    // ->with(['type', 'apartements' => function ($query) {
    //     $query->where('nbr_available', '>', 0);
    // }])->get();
    // return response()->json($properties);

    // public function getAllProperties()
    // {

    //     $properties = Property::where('etat', 'pending')
    //         ->whereHas('apartements', function ($query) {
    //             $query->where('nbr_available', '>', 0);
    //         })
    //         ->with([
    //             'type',
    //             'apartements' => function ($query) {
    //                 $query->where('nbr_available', '>', 0)
    //                     ->with(['tarifications']);
    //             }
    //         ])
    //         ->get()
    //     ->map(function ($property) {
    //     $tarifsHeure = [];
    //     $tarifsJour = [];

    //     foreach ($property->apartements as $appartement) {
    //         foreach ($appartement->tarifications as $tarif) {
    //             if ($tarif->sejour === 'Heure') {
    //                 $tarifsHeure[] = $tarif->price;
    //             } elseif ($tarif->sejour === 'Jour') {
    //                 $tarifsJour[] = $tarif->price;
    //             }
    //         }
    //     }

    //     $minHeure = !empty($tarifsHeure) ? min($tarifsHeure) : null;
    //     $minJour = !empty($tarifsJour) ? min($tarifsJour) : null;

    //     if ($minHeure !== null && ($minJour === null || $minHeure < $minJour)) {
    //         $property->min_tarif = $minHeure;
    //         $property->tarif_type = 'Heure';
    //     } elseif ($minJour !== null) {
    //         $property->min_tarif = $minJour;
    //         $property->tarif_type = 'Jour';
    //     } else {
    //         $property->min_tarif = null;
    //         $property->tarif_type = null;
    //     }

    //     return $property;
    //     });

    //     return response()->json($properties);
    // }

    public function getAllProperties()
    {
        $properties = Property::where('etat', 'actif')
            ->whereHas('apartements', function ($query) {
                $query->where('nbr_available', '>', 0);
            })
            ->with([
                'type',
                'apartements' => function ($query) {
                    $query->where('nbr_available', '>', 0)
                        ->with('tarifications');
                }
            ])
            ->get()
            ->map(function ($property) {
                $tarifsHeure = [];
                $tarifsJour = [];

                $minHeureTarif = null;
                $minJourTarif = null;

                foreach ($property->apartements as $appartement) {
                    foreach ($appartement->tarifications as $tarif) {
                        if ($tarif->sejour == 'Heure') {
                            $tarifsHeure[] = $tarif;
                        } elseif ($tarif->sejour == 'Jour') {
                            $tarifsJour[] = $tarif;
                        }
                    }
                }

                if (!empty($tarifsHeure)) {
                    $minHeureTarif = collect($tarifsHeure)->sortBy('price')->first();
                }

                if (!empty($tarifsJour)) {
                    $minJourTarif = collect($tarifsJour)->sortBy('price')->first();
                }

                if ($minHeureTarif && (!$minJourTarif || $minHeureTarif->price < $minJourTarif->price)) {
                    $property->min_tarif = $minHeureTarif->price;
                    $property->tarif_type = 'Heure';
                    $property->nbr_sejour = $minHeureTarif->nbr_of_sejour;
                } elseif ($minJourTarif) {
                    $property->min_tarif = $minJourTarif->price;
                    $property->tarif_type = 'Jour';
                    $property->nbr_sejour = $minJourTarif->nbr_of_sejour;
                } else {
                    $property->min_tarif = null;
                    $property->tarif_type = null;
                    $property->nbr_sejour = null;
                }

                return $property;
            });

        return response()->json($properties);
    }
    public function indexReservations()
    {
        return view('pages.reservation');
    }
    public function appartByProperty($uuid)
    {
        $apparts = Appartement::where('property_uuid', $uuid)->where('etat', '=', 'actif', 'and', 'nbr_available', '>', 0)->get();
        return view('pages.apparts', compact('apparts'));
    }
    public function allApparts()
    {
        $apparts = Appartement::where('etat', '=', 'actif', 'and', 'nbr_available', '>', 0)->get();
        return view('pages.showAllApparts', compact('apparts'));
    }
    public function indexApropos()
    {
        return view('pages.apropos');
    }
    public function indexContact()
    {
        return view('pages.contact');
    }
    public function indexFaq()
    {
        return view('pages.faq');
    }
    public function indexPolitiq()
    {
        return view('pages.politiq');
    }
    public function show(string $uuid)
    {
        $appart = Appartement::where('etat', '=', 'actif')->where('uuid', $uuid)->first();
        // dd($appart);
        return view('pages.detail', compact('appart'));
    }


    public function addComment(Request $request)
    {

        $comment = Comment::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'appart_uuid' => $request->appart_uuid,
            'property_uuid' => $request->property_uuid,
            'partner_uuid' => $request->partner_uuid,
            'email' => $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout du commentaire',
                'code' => 500
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Commentaire ajouté avec succès',
            'data' => $comment,
            'code' => 200
        ]);
    }

    // public function getComments(Request $request)
    // {
    //     $perPage = $request->get('perPage', 2);

    //     $comments = Comment::orderBy('created_at', 'desc')->paginate($perPage);

    //     return response()->json($comments);
    // }

    public function getComments(Request $request)
    {
        $perPage = $request->get('perPage', 2);

        $comments = Comment::where('appart_uuid', $request->appart_uuid)->where('etat', 'actif')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return response()->json([
            'data' => $comments->items(),
            'meta' => [
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total()
            ]
        ]);
    }
}
