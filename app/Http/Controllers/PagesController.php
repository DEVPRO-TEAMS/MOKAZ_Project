<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\User;
use App\Models\Search;

use App\Models\Comment;
use App\Models\Partner;
use App\Models\Property;
use App\Models\Variable;
use App\Models\Appartement;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use function PHPSTORM_META\type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{

    public function index(Request $request)
    {
        // 📋 Récupération des types d'appartements actifs
        $typeAppart = Variable::where(['type' => 'type_of_appart', 'etat' => 'actif'])->get();

        // ⚙️ Paramètres de pagination et de requête
        $perPage = $request->get('perPage', 6);
        $latitudeUser = $request->get('lat');
        $longitudeUser = $request->get('lng');
        $search = trim($request->input('search'));
        $location = trim($request->input('location'));
        $type = $request->input('type');
        $ville = $request->input('ville');
        $categorie = $request->input('categorie');

        // créer une session pour stocker les latitudeUser et longitudeUser
        session(['lat' => $latitudeUser, 'lng' => $longitudeUser]);

        //  Si l'utilisateur fait une recherche manuelle, on ignore la géolocalisation
        $useGeolocation = !($search || $location || $type || $categorie || $ville);

        // Requête de base : on récupère les appartements actifs via la table Search
        $searchQuery = Search::query();

        // Recherche texte dans la colonne "query"
        // if ($search || $location || $ville || $categorie || $type) {
        //     $searchData->where(function($q) use ($search, $location, $ville, $categorie, $type) {
        //         if ($search) {
        //             $q->where('query', 'like', "%$search%");
        //         }
        //         if ($location) {
        //             $q->orWhere('query', 'like', "%$location%");
        //         }
        //         if ($ville) {
        //             $q->orWhere('query', 'like', "%$ville%");
        //         }
        //         if ($categorie) {
        //             $q->orWhere('query', 'like', "%$categorie%");
        //         }
        //         if ($type) {
        //             $q->orWhere('query', 'like', "%$type%");
        //         }
        //     });
        // }
        // 1️⃣ Recherche mot-clé
        if ($search) {
            // $searchQuery->where('query', 'like', "%$search%");
            $fulltextConditions = array_filter([$search]);

            if (!empty($fulltextConditions)) {
                $match = implode(' ', $fulltextConditions);
                $searchQuery->whereRaw("MATCH(query) AGAINST(? IN BOOLEAN MODE)", [$match]);
            }
        }

        // 2️⃣ Filtre par localisation
        if ($location) {
            $searchQuery->where('query', 'like', "%$location%");
        }

        // 3️⃣ Filtre par ville
        if ($ville) {
            $searchQuery->where('query', 'like', "%$ville%");
        }

        // 4️⃣ Filtre par catégorie
        if ($categorie) {
            $searchQuery->where('query', 'like', "%$categorie%");
        }

        // 5️⃣ Filtre par type
        if ($type) {
            $searchQuery->where('query', 'like', "%$type%");
        }

        // 🔹 Récupérer les appartements qui correspondent à TOUS les filtres
        $appartementIds = $searchQuery->pluck('appartement_uuid')->toArray();

        // Requête de base : appartements actifs et disponibles
        $query = Appartement::with('property')
            ->where('appartements.etat', 'actif')
            ->where('appartements.nbr_available', '>', 0)
            ->whereIn('uuid', $appartementIds);

        // Calcul de distance Haversine et tri si coordonnées fournies
        if ($latitudeUser && $longitudeUser) {
            $haversine = "(6371 * acos(cos(radians($latitudeUser)) 
            * cos(radians(properties.latitude)) 
            * cos(radians(properties.longitude) - radians($longitudeUser)) 
            + sin(radians($latitudeUser)) 
            * sin(radians(properties.latitude))))";

            // Filtrer sur la distance ≤ 10 km si géolocalisation active
            if ($useGeolocation) {
                $query->whereHas('property', function ($q) use ($haversine) {
                    $q->whereRaw("$haversine <= 10");
                });

                // Ajouter la distance au SELECT et trier par distance croissante
                $query->with(['property' => function ($q) use ($haversine) {
                    $q->addSelect([
                        'properties.*',
                        DB::raw("$haversine AS distance_km")
                    ]);
                }])
                    ->join('properties', 'appartements.property_uuid', '=', 'properties.uuid')
                    ->select('appartements.*', DB::raw("$haversine AS distance_km"))
                    ->orderBy('distance_km', 'asc')
                    ->orderBy('appartements.created_at', 'desc');
            } else {
                // Ajouter la distance au SELECT de la relation property
                $query->with(['property' => function ($q) use ($haversine) {
                    $q->addSelect([
                        'properties.*',
                        DB::raw("$haversine AS distance_km")
                    ]);
                }]);
            }
        } else {
            // Tri par date de création si pas de géolocalisation
            $query->orderBy('appartements.created_at', 'desc');
        }

        // Pagination des appartements
        $apparts = $query->paginate($perPage);

        // Meilleurs appartements (ceux ayant le plus de réservations)
        $bestApparts = Appartement::withCount('reservations')
            ->where('appartements.etat', 'actif')
            ->where('appartements.nbr_available', '>', 0)
            ->orderByDesc('reservations_count')
            ->take(3)
            ->with('tarifications')
            ->get();

        // Liste des localisations groupées (Pays - Ville)
        $locations = Property::with(['ville.locationImage', 'pays'])
            ->where('etat', 'actif')
            ->get()
            ->groupBy(function ($property) {
                return $property->pays?->label . ' - ' . $property->ville?->label;
            });
        $testimonials = Testimonial::all();

        $categories = Variable::where(['type' => 'category_of_property', 'etat' => 'actif'])->get();
        $cities = city::where('country_code', 'CIV')->get();
        return view('welcome', compact('apparts', 'bestApparts', 'typeAppart', 'locations', 'testimonials', 'categories', 'cities'));
    }

    // public function index(Request $request)
    // {
    //     // 📋 Récupération des types d'appartements actifs
    //     $typeAppart = Variable::where(['type' => 'type_of_appart', 'etat' => 'actif'])->get();

    //     // ⚙️ Paramètres de pagination et de requête
    //     $perPage = $request->get('perPage', 6);
    //     $latitudeUser = $request->get('lat');
    //     $longitudeUser = $request->get('lng');
    //     $search = trim($request->input('search'));
    //     $location = trim($request->input('location'));
    //     $type = $request->input('type');
    //     $ville = $request->input('ville');
    //     $categorie = $request->input('categorie');

    //     // créer une session pour stocker les latitudeUser et longitudeUser
    //     session(['lat' => $latitudeUser, 'lng' => $longitudeUser]);

    //     //  Si l'utilisateur fait une recherche manuelle, on ignore la géolocalisation
    //     $useGeolocation = !($search || $location || $type || $categorie || $ville);

    //     //  Requête de base : appartements actifs et disponibles
    //     $query = Appartement::with('property')
    //         ->where('appartements.etat', 'actif')
    //         ->where('appartements.nbr_available', '>', 0);

    //     // Recherche par mot-clé / localisation
    //     if ($search || $location || $categorie) {
    //         $query->where(function ($q) use ($search, $location, $categorie) {
    //             if ($search) {
    //                 $q->where('title', 'like', "%$search%")
    //                     ->orWhere('description', 'like', "%$search%")
    //                     ->orWhere('commodities', 'like', "%$search%");
    //             }

    //             if ($location) {
    //                 $q->orWhere('title', 'like', "%$location%")
    //                     ->orWhere('description', 'like', "%$location%");
    //             }

    //             $q->orWhereHas('property', function ($q2) use ($search, $location, $categorie) {
    //                 if ($search) {
    //                     $q2->where('title', 'like', "%$search%")
    //                         ->orWhere('description', 'like', "%$search%")
    //                         ->orWhere('address', 'like', "%$search%")
    //                         ->orWhere('city', 'like', "%$search%")
    //                         ->orWhere('country', 'like', "%$search%");
    //                 }

    //                 if ($location) {
    //                     $q2->orWhere('title', 'like', "%$location%")
    //                         ->orWhere('description', 'like', "%$location%")
    //                         ->orWhere('address', 'like', "%$location%")
    //                         ->orWhere('city', 'like', "%$location%")
    //                         ->orWhere('country', 'like', "%$location%");
    //                 }

    //                 // Filtre par categorie
    //                 if ($categorie) {
    //                     $q2->where('category_uuid', $categorie);
    //                 }
    //             });
    //         });
    //     }

    //     // Filtre par type
    //     if ($type) {
    //         $query->where('type_uuid', $type);
    //     }

    //     // Calcul de distance Haversine et tri si coordonnées fournies
    //     if ($latitudeUser && $longitudeUser) {
    //         $haversine = "(6371 * acos(cos(radians($latitudeUser)) 
    //         * cos(radians(properties.latitude)) 
    //         * cos(radians(properties.longitude) - radians($longitudeUser)) 
    //         + sin(radians($latitudeUser)) 
    //         * sin(radians(properties.latitude))))";

    //         // Filtrer sur la distance ≤ 10 km si géolocalisation active
    //         if ($useGeolocation) {
    //             $query->whereHas('property', function ($q) use ($haversine) {
    //                 $q->whereRaw("$haversine <= 10");
    //             });

    //             // Ajouter la distance au SELECT et trier par distance croissante
    //             $query->with(['property' => function ($q) use ($haversine) {
    //                 $q->addSelect([
    //                     'properties.*',
    //                     DB::raw("$haversine AS distance_km")
    //                 ]);
    //             }])
    //                 ->join('properties', 'appartements.property_uuid', '=', 'properties.uuid')
    //                 ->select('appartements.*', DB::raw("$haversine AS distance_km"))
    //                 ->orderBy('distance_km', 'asc')
    //                 ->orderBy('appartements.created_at', 'desc');
    //         } else {
    //             // Ajouter la distance au SELECT de la relation property
    //             $query->with(['property' => function ($q) use ($haversine) {
    //                 $q->addSelect([
    //                     'properties.*',
    //                     DB::raw("$haversine AS distance_km")
    //                 ]);
    //             }]);
    //         }
    //     } else {
    //         // Tri par date de création si pas de géolocalisation
    //         $query->orderBy('appartements.created_at', 'desc');
    //     }

    //     // Pagination des appartements
    //     $apparts = $query->paginate($perPage);

    //     // Meilleurs appartements (ceux ayant le plus de réservations)
    //     $bestApparts = Appartement::withCount('reservations')
    //         ->where('appartements.etat', 'actif')
    //         ->where('appartements.nbr_available', '>', 0)
    //         ->orderByDesc('reservations_count')
    //         ->take(3)
    //         ->with('tarifications')
    //         ->get();

    //     // Liste des localisations groupées (Pays - Ville)
    //     $locations = Property::with(['ville.locationImage', 'pays'])
    //         ->where('etat', 'actif')
    //         ->get()
    //         ->groupBy(function ($property) {
    //             return $property->pays?->label . ' - ' . $property->ville?->label;
    //         });
    //     $testimonials = Testimonial::all();

    //     $categories = Variable::where(['type' => 'category_of_property', 'etat' => 'actif'])->get();
    //     $cities = city::where('country_code', 'CIV')->get();
    //     return view('welcome', compact('apparts', 'bestApparts', 'typeAppart', 'locations', 'testimonials', 'categories', 'cities'));
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
    public function appartByProperty(Request $request, $uuid)
    {
        $typeAppart = Variable::where(['type' => 'type_of_appart', 'etat' => 'actif'])->get();
        $perPage = $request->get('perPage', 6);
        $categorie = $request->input('categorie');
        // recuperer les coordonnées de l'utilisateur dans la session
        $latitudeUser = session()->get('lat');
        $longitudeUser = session()->get('lng');
        $ville = $request->input('ville');

        $type = $request->input('type');

        // $query = Appartement::with('property')
        //     ->where('appartements.property_uuid', $uuid)
        //     ->where('appartements.etat', 'actif')
        //     ->where('appartements.nbr_available', '>', 0);

        $search = $request->input('search');
        $location = $request->input('location');

        //  Si l'utilisateur fait une recherche manuelle, on ignore la géolocalisation
        $useGeolocation = !($search || $location || $type || $categorie);

        // Requête de base : on récupère les appartements actifs via la table Search
        $searchQuery = Search::query();
        // 1️⃣ Recherche mot-clé
        if ($search) {
            // $searchQuery->where('query', 'like', "%$search%");
            $fulltextConditions = array_filter([$search]);

            if (!empty($fulltextConditions)) {
                $match = implode(' ', $fulltextConditions);
                $searchQuery->whereRaw("MATCH(query) AGAINST(? IN BOOLEAN MODE)", [$match]);
            }
        }

        // 2️⃣ Filtre par localisation
        if ($location) {
            $searchQuery->where('query', 'like', "%$location%");
        }

        // 3️⃣ Filtre par ville
        if ($ville) {
            $searchQuery->where('query', 'like', "%$ville%");
        }

        // 4️⃣ Filtre par catégorie
        if ($categorie) {
            $searchQuery->where('query', 'like', "%$categorie%");
        }

        // 5️⃣ Filtre par type
        if ($type) {
            $searchQuery->where('query', 'like', "%$type%");
        }

        // 🔹 Récupérer les appartements qui correspondent à TOUS les filtres
        $appartementIds = $searchQuery->pluck('appartement_uuid')->toArray();

        // Requête de base : appartements actifs et disponibles
        $query = Appartement::with('property')
            ->where('appartements.etat', 'actif')
            ->where('appartements.nbr_available', '>', 0)
            ->whereIn('uuid', $appartementIds);

        // // Recherche par mot-clé / localisation
        // if ($search || $location || $categorie) {
        //     $query->where(function ($q) use ($search, $location, $categorie) {

        //         // 🔹 Recherche dans le modèle Appartement
        //         if ($search) {
        //             $q->where('title', 'like', "%$search%")
        //                 ->orWhere('description', 'like', "%$search%")
        //                 ->orWhere('commodities', 'like', "%$search%");
        //         }

        //         if ($location) {
        //             $q->orWhere('title', 'like', "%$location%")
        //                 ->orWhere('description', 'like', "%$location%");
        //         }

        //         // 🔹 Recherche dans le modèle Property lié
        //         $q->orWhereHas('property', function ($q2) use ($search, $location, $categorie) {
        //             if ($search) {
        //                 $q2->where('title', 'like', "%$search%")
        //                     ->orWhere('description', 'like', "%$search%")
        //                     ->orWhere('address', 'like', "%$search%")
        //                     ->orWhere('city', 'like', "%$search%")
        //                     ->orWhere('country', 'like', "%$search%");
        //             }

        //             if ($location) {
        //                 $q2->orWhere('title', 'like', "%$location%")
        //                     ->orWhere('description', 'like', "%$location%")
        //                     ->orWhere('address', 'like', "%$location%")
        //                     ->orWhere('city', 'like', "%$location%")
        //                     ->orWhere('country', 'like', "%$location%");
        //             }
        //             // Filtre par categorie
        //             if ($categorie) {
        //                 $q2->where('category_uuid', $categorie);
        //             }
        //         });
        //     });
        // }

        // // Filtre par type d'appartement
        // if ($request->filled('type')) {
        //     $query->where('type_uuid', $request->type);
        // }



        // Calcul de distance Haversine et tri si coordonnées fournies
        if ($latitudeUser && $longitudeUser) {
            $haversine = "(6371 * acos(cos(radians($latitudeUser)) 
            * cos(radians(properties.latitude)) 
            * cos(radians(properties.longitude) - radians($longitudeUser)) 
            + sin(radians($latitudeUser)) 
            * sin(radians(properties.latitude))))";

            if ($useGeolocation) {
                // $query->whereHas('property', function ($q) use ($haversine) {
                //     $q->whereRaw("$haversine <= 10");
                // });

                // Ajouter la distance au SELECT et trier par distance croissante
                $query->with(['property' => function ($q) use ($haversine) {
                    $q->addSelect([
                        'properties.*',
                        DB::raw("$haversine AS distance_km")
                    ]);
                }])
                    ->join('properties', 'appartements.property_uuid', '=', 'properties.uuid')
                    ->select('appartements.*', DB::raw("$haversine AS distance_km"))
                    ->orderBy('distance_km', 'asc')
                    ->orderBy('appartements.created_at', 'desc');
            } else {
                // Ajouter la distance au SELECT de la relation property
                $query->with(['property' => function ($q) use ($haversine) {
                    $q->addSelect([
                        'properties.*',
                        DB::raw("$haversine AS distance_km")
                    ]);
                }]);
            }
        } else {
            // Tri par date de création si pas de géolocalisation
            $query->orderBy('appartements.created_at', 'desc');
        }

        // Pagination des appartements
        $apparts = $query->paginate($perPage);

        // $apparts = $query->orderBy('created_at', 'desc')->paginate($perPage);
        $categories = Variable::where(['type' => 'category_of_property', 'etat' => 'actif'])->get();
        
        $cities = city::where('country_code', 'CIV')->get();
        return view('pages.apparts', compact('apparts', 'typeAppart', 'uuid', 'categories', 'cities'));
    }
    // public function allApparts(Request $request)
    // {
    //     $typeAppart = Variable::where(['type' => 'type_of_appart', 'etat' => 'actif'])->get();
    //     $perPage = $request->get('perPage', 6);

    //     $query = Appartement::with('property');

    //     // Recherche par mot-clé ou localisation
    //     if ($request->filled('search') || $request->filled('location')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->search . '%')
    //                 ->orWhere('title', 'like', '%' . $request->location . '%')
    //                 ->orWhere('description', 'like', '%' . $request->search . '%')
    //                 ->orWhere('description', 'like', '%' . $request->location . '%')
    //                 ->orWhere('commodities', 'like', '%' . $request->search . '%');
    //         });

    //         $query->whereHas('property', function ($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->location . '%')
    //                 ->orWhere('title', 'like', '%' . $request->search . '%')
    //                 ->orWhere('description', 'like', '%' . $request->location . '%')
    //                 ->orWhere('country', 'like', '%' . $request->location . '%')
    //                 ->orWhere('country', 'like', '%' . $request->search . '%')
    //                 ->orWhere('city', 'like', '%' . $request->location . '%')
    //                 ->orWhere('city', 'like', '%' . $request->search . '%')
    //                 ->orWhere('address', 'like', '%' . $request->location . '%');
    //         });
    //     }

    //     // Filtre par type
    //     if ($request->filled('type')) {
    //         $query->where('type_uuid', $request->type);
    //     }

    //     $apparts = $query->where('etat', 'actif')
    //         ->where('nbr_available', '>', 0)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate($perPage);
    //     // $apparts = Appartement::where('etat', '=', 'actif', 'and', 'nbr_available', '>', 0)->orderBy('created_at', 'desc')->paginate($perPage);
    //     return view('pages.showAllApparts', compact('apparts', 'typeAppart'));
    // }

    public function allApparts(Request $request)
    {
        $typeAppart = Variable::where(['type' => 'type_of_appart', 'etat' => 'actif'])->get();
        $perPage = $request->get('perPage', 6);

        // $query = Appartement::with('property')->where('etat', 'actif')->where('nbr_available', '>', 0);
        // $query = Appartement::with('property')
        //     ->where('appartements.etat', 'actif')
        //     ->where('appartements.nbr_available', '>', 0);

        $search = $request->input('search');
        $location = $request->input('location');
        $categorie = $request->input('categorie');
        $type = $request->input('type');
        $ville = $request->input('ville');
        // recuperer les coordonnées de l'utilisateur dans la session
        $latitudeUser = session()->get('lat');
        $longitudeUser = session()->get('lng');
        //  Si l'utilisateur fait une recherche manuelle, on ignore la géolocalisation
        $useGeolocation = !($search || $location || $type || $categorie);

        // if ($search || $location || $categorie) {
        //     $query->where(function ($q) use ($categorie, $search, $location) {

        //         // 🔹 Recherche dans le modèle Appartement
        //         if ($search) {
        //             $q->where('title', 'like', "%$search%")
        //                 ->orWhere('description', 'like', "%$search%")
        //                 ->orWhere('commodities', 'like', "%$search%");
        //         }

        //         if ($location) {
        //             $q->orWhere('title', 'like', "%$location%")
        //                 ->orWhere('description', 'like', "%$location%");
        //         }

        //         // 🔹 Recherche dans le modèle Property lié
        //         $q->orWhereHas('property', function ($q2) use ($search, $location, $categorie) {
        //             if ($search) {
        //                 $q2->where('title', 'like', "%$search%")
        //                     ->orWhere('description', 'like', "%$search%")
        //                     ->orWhere('address', 'like', "%$search%")
        //                     ->orWhere('city', 'like', "%$search%")
        //                     ->orWhere('country', 'like', "%$search%");
        //             }

        //             if ($location) {
        //                 $q2->orWhere('title', 'like', "%$location%")
        //                     ->orWhere('description', 'like', "%$location%")
        //                     ->orWhere('address', 'like', "%$location%")
        //                     ->orWhere('city', 'like', "%$location%")
        //                     ->orWhere('country', 'like', "%$location%");
        //             }

        //             // Filtre par categorie
        //             if ($categorie) {
        //                 $q2->where('category_uuid', $categorie);
        //             }
        //         });
        //     });
        // }

        // // Filtre par type d'appartement
        // if ($request->filled('type')) {
        //     $query->where('type_uuid', $request->type);
        // }

        // Requête de base : on récupère les appartements actifs via la table Search
        $searchQuery = Search::query();
        // 1️⃣ Recherche mot-clé
        if ($search) {
            // $searchQuery->where('query', 'like', "%$search%");
            $fulltextConditions = array_filter([$search]);

            if (!empty($fulltextConditions)) {
                $match = implode(' ', $fulltextConditions);
                $searchQuery->whereRaw("MATCH(query) AGAINST(? IN BOOLEAN MODE)", [$match]);
            }
        }

        // 2️⃣ Filtre par localisation
        if ($location) {
            $searchQuery->where('query', 'like', "%$location%");
        }

        // 3️⃣ Filtre par ville
        if ($ville) {
            $searchQuery->where('query', 'like', "%$ville%");
        }

        // 4️⃣ Filtre par catégorie
        if ($categorie) {
            $searchQuery->where('query', 'like', "%$categorie%");
        }

        // 5️⃣ Filtre par type
        if ($type) {
            $searchQuery->where('query', 'like', "%$type%");
        }

        // 🔹 Récupérer les appartements qui correspondent à TOUS les filtres
        $appartementIds = $searchQuery->pluck('appartement_uuid')->toArray();

        // Requête de base : appartements actifs et disponibles
        $query = Appartement::with('property')
            ->where('appartements.etat', 'actif')
            ->where('appartements.nbr_available', '>', 0)
            ->whereIn('appartements.uuid', $appartementIds);

        // Calcul de distance Haversine et tri si coordonnées fournies
        if ($latitudeUser && $longitudeUser) {
            $haversine = "(6371 * acos(cos(radians($latitudeUser)) 
            * cos(radians(properties.latitude)) 
            * cos(radians(properties.longitude) - radians($longitudeUser)) 
            + sin(radians($latitudeUser)) 
            * sin(radians(properties.latitude))))";

            if ($useGeolocation) {
                // $query->whereHas('property', function ($q) use ($haversine) {
                //     $q->whereRaw("$haversine <= 10");
                // });

                // Ajouter la distance au SELECT et trier par distance croissante
                $query->with(['property' => function ($q) use ($haversine) {
                    $q->addSelect([
                        'properties.*',
                        DB::raw("$haversine AS distance_km")
                    ]);
                }])
                    ->join('properties', 'appartements.property_uuid', '=', 'properties.uuid')
                    ->select('appartements.*', DB::raw("$haversine AS distance_km"))
                    ->orderBy('distance_km', 'asc')
                    ->orderBy('appartements.created_at', 'desc');
            } else {
                // Ajouter la distance au SELECT de la relation property
                $query->with(['property' => function ($q) use ($haversine) {
                    $q->addSelect([
                        'properties.*',
                        DB::raw("$haversine AS distance_km")
                    ]);
                }]);
            }
        } else {
            // Tri par date de création si pas de géolocalisation
            $query->orderBy('appartements.created_at', 'desc');
        }

        // Pagination des appartements
        $apparts = $query->paginate($perPage);

        // $apparts = $query->orderBy('created_at', 'desc')->paginate($perPage);
        $categories = Variable::where(['type' => 'category_of_property', 'etat' => 'actif'])->get();
        $cities = city::where('country_code', 'CIV')->get();

        return view('pages.showAllApparts', compact('apparts', 'typeAppart', 'categories', 'cities'));
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

        $to = '2250758817235';
        $message = 'test sms';
        $response = sendSms($to, $message);

        return response()->json([
            'status' => 'success',
            'to' => $to,
            'message' => $message,
            'api_response' => $response
        ]);
    }


    public function contratPrestataire(Request $request, $email)
    {
        $partner = Partner::where('email', $email)->first();
        $user = User::where('email', $email)->first();
        $pdf = Pdf::loadView('mail.contrat', compact('partner', 'user'));
        // return $pdf->stream('contrat-prestataire.pdf');
        return $pdf->download('fiche_prestation.pdf');
    }
}
