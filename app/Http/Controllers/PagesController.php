<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Property;
use App\Models\Variable;

use App\Models\Appartement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;
use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{
    // public function index(Request $request)
    // {
    //     $typeAppart = Variable::where(['type' => 'type_of_appart', 'etat' => 'actif'])->get();

    //     $perPage = $request->get('perPage', 6);

    //     $query = Appartement::with('property');

    //     // Recherche par mot-clé
    //     if ($request->filled('search')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->search . '%')
    //                 ->orWhere('description', 'like', '%' . $request->search . '%')
    //                 ->orWhere('commodities', 'like', '%' . $request->search . '%')
    //                 ->orWhere('nbr_room', 'like', '%' . $request->search . '%')
    //                 ->orWhere('nbr_bathroom', 'like', '%' . $request->search . '%');
    //         });
    //     }

    //     // Recherche par localisation (dans Property)
    //     if ($request->filled('location')) {
    //         $query->whereHas('property', function ($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->location . '%')
    //                 ->orWhere('address', 'like', '%' . $request->location . '%')
    //                 ->orWhere('longitude', 'like', '%' . $request->location . '%')
    //                 ->orWhere('latitude', 'like', '%' . $request->location . '%')
    //                 ->orWhere('description', 'like', '%' . $request->location . '%');
    //         });
    //     }

    //     // Filtre par type
    //     if ($request->filled('type')) {
    //         $query->where('type_uuid', $request->type);
    //     }

    //     // Récupérer les appartements actifs
    //     $apparts = $query->where('etat', 'actif')
    //         ->orderBy('created_at', 'desc')
    //         ->paginate($perPage);

    //     $bestApparts = Appartement::withCount('reservations')
    //         ->where('etat', 'actif')
    //         ->where('nbr_available', '>', 0)
    //         ->orderByDesc('reservations_count')
    //         ->take(3)
    //         ->with('tarifications') // si tu as une relation tarifications() dans le modèle Appartement
    //         ->get();

    //     return view('welcome', compact('apparts', 'bestApparts', 'typeAppart'));
    // }

    public function index(Request $request)
{
    $typeAppart = Variable::where(['type' => 'type_of_appart', 'etat' => 'actif'])->get();
    $perPage = $request->get('perPage', 6);
    $latitudeUser = $request->get('lat');
    $longitudeUser = $request->get('lng');

    $query = Appartement::with('property');

    // Recherche par mot-clé
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%')
              ->orWhere('commodities', 'like', '%' . $request->search . '%');
        });
    }

    // Recherche par localisation (dans Property)
    if ($request->filled('location')) {
        $query->whereHas('property', function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->location . '%')
              ->orWhere('address', 'like', '%' . $request->location . '%');
        });
    }

    // Filtre par type
    if ($request->filled('type')) {
        $query->where('type_uuid', $request->type);
    }

    // Filtre par distance si lat/lng fournis
    if ($latitudeUser && $longitudeUser) {
        $haversine = "(6371 * acos(cos(radians($latitudeUser)) 
                        * cos(radians(properties.latitude)) 
                        * cos(radians(properties.longitude) - radians($longitudeUser)) 
                        + sin(radians($latitudeUser)) 
                        * sin(radians(properties.latitude))))";

        $query->whereHas('property', function($q) use ($haversine) {
            $q->whereRaw("$haversine <= 1.5"); // distance <= 1.5 km
        });
    }

    $apparts = $query->where('etat', 'actif')
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);

    $bestApparts = Appartement::withCount('reservations')
                        ->where('etat', 'actif')
                        ->where('nbr_available', '>', 0)
                        ->orderByDesc('reservations_count')
                        ->take(3)
                        ->with('tarifications')
                        ->get();

    return view('welcome', compact('apparts', 'bestApparts', 'typeAppart'));
}

    // public function index(Request $request)
    // {
    //     $typeAppart = Variable::where(['type' => 'type_of_appart', 'etat' => 'actif'])->get();

    //     $query = Appartement::with('property');

    //     // Recherche par mot-clé
    //     if ($request->filled('search')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->search . '%')
    //                 ->orWhere('description', 'like', '%' . $request->search . '%')
    //                 ->orWhere('commodities', 'like', '%' . $request->search . '%')
    //                 ->orWhere('nbr_room', 'like', '%' . $request->search . '%')
    //                 ->orWhere('nbr_bathroom', 'like', '%' . $request->search . '%');
    //         });
    //     }

    //     // Recherche par localisation (dans Property)
    //     if ($request->filled('location')) {
    //         $query->whereHas('property', function ($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->location . '%')
    //                 ->orWhere('address', 'like', '%' . $request->location . '%')
    //                 ->orWhere('longitude', 'like', '%' . $request->location . '%')
    //                 ->orWhere('latitude', 'like', '%' . $request->location . '%')
    //                 ->orWhere('description', 'like', '%' . $request->location . '%');
    //         });
    //     }

    //     // Filtre par type
    //     if ($request->filled('type')) {
    //         $query->where('type_uuid', $request->type);
    //     }

    //     // Récupérer les appartements actifs
    //     $apparts = $query->where('etat', 'actif')
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     $bestApparts = Appartement::withCount('reservations')
    //         ->where('etat', 'actif')
    //         ->where('nbr_available', '>', 0)
    //         ->orderByDesc('reservations_count')
    //         ->take(3)
    //         ->with('tarifications') // si tu as une relation tarifications() dans le modèle Appartement
    //         ->get();

    //     return view('welcome', compact('apparts', 'bestApparts', 'typeAppart'));
    // }

    public function getAllProperties()
    {
        $properties = Property::where('etat', 'actif')
            ->whereHas('apartements', function ($query) {
                $query->where('nbr_available', '>', 0)->where('etat', 'actif');
            })
            ->with([
                'type',
                'apartements' => function ($query) {
                    $query->where('nbr_available', '>', 0)
                        ->where('etat', 'actif')
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
    public function appartByProperty(Request $request ,$uuid)
    {
        $perPage = $request->get('perPage', 6);
        $apparts = Appartement::where('property_uuid', $uuid)->where('etat', '=', 'actif', 'and', 'nbr_available', '>', 0)->orderBy('created_at', 'desc')->paginate($perPage);
        return view('pages.apparts', compact('apparts'));
    }
    public function allApparts(Request $request)
    {
        $perPage = $request->get('perPage', 6);
        $apparts = Appartement::where('etat', '=', 'actif', 'and', 'nbr_available', '>', 0)->orderBy('created_at', 'desc')->paginate($perPage);
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

    public function demoSms(Request $request)
    {

        $to = '2250789078557';
        $message = 'test sms';
        $response = sendSms($to, $message);

        return response()->json([
            'status' => 'success',
            'to' => $to,
            'message' => $message,
            'api_response' => $response
        ]);


        
    }
}
