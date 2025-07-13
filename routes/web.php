<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Partner\PartnerController;
use App\Http\Controllers\Properties\PropertyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// route de navigation
Route::get('/apropos', [PagesController::class, 'indexApropos'])->name('apropos');
Route::get('/reservation', [PagesController::class, 'indexReservations'])->name('reservation');
Route::get('/contact', [PagesController::class, 'indexContact'])->name('contact');
Route::get('/faq', [PagesController::class, 'indexFaq'])->name('faq');
Route::get('/confidentialite', [PagesController::class, 'indexPolitiq'])->name('politiq');
Route::get('/detail/property', [PagesController::class, 'show'])->name('property.show');




Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware('guest', 'PreventBackHistory')->group(function(){

    });
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/import-city-country', [AdminController::class, 'importCityCountry'])->name('import.city.country');

        Route::get('/dashboard', [AdminController::class, 'index'])->name('index');

        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');

        // validation de demande de partenariat 

        Route::get('/demande/list', [AdminController::class, 'viewDemande'])->name('demande.view');
        Route::get('/allProprety/list', [AdminController::class, 'allProprety'])->name('proprety.view');
        Route::get('/partner/list', [PartnerController::class, 'index'])->name('partner.index');
    });
});

Route::prefix('user')->name('user.')->group(function(){
    Route::middleware('guest', 'PreventBackHistory')->group(function(){

    });
    Route::middleware(['auth', 'user'])->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('index');
    });
});

Route::prefix('partner')->name('partner.')->group(function(){
    Route::middleware('guest', 'PreventBackHistory')->group(function(){
        Route::post('demande/store', [PartnerController::class, 'store']);
    });
    Route::middleware(['auth', 'partner'])->group(function () {
        Route::get('/dashboard', [PartnerController::class, 'index'])->name('index');

        // Route property
        Route::get('/my-properties', [PropertyController::class, 'index'])->name('properties.index');
        Route::get('/property/create', [PropertyController::class, 'create'])->name('properties.create');
        // Route::post('/property/store', [PropertyController::class, 'store'])->name('properties.store') api property dans api.php;
        Route::get('/property/show/{property_code}', [PropertyController::class, 'show'])->name('properties.show');
    });
});


Route::prefix('setting')->name('setting.')->group(function(){
    Route::middleware('guest', 'PreventBackHistory')->group(function(){
    });
    Route::middleware(['auth'])->group(function () {
    });
});



Route::get('api/country', function () {
    $response = Http::get('https://iso.lahrim.fr/countries');

    $data = $response->json();

    if (!is_array($data) || !isset($data['data'])) {
        return response()->json(['error' => 'Réponse invalide de l’API'], 500);
    }

    $countries = collect($data['data'])->map(function ($item) {
        return [
            'name' => $item['name'] ?? 'N/A',
            'flag' => $item['flag'] ?? '',
        ];
    });

    return $countries->values();
});
// Route::get('api/cities', function () {
//     $allCities = [];

//     $baseUrl = 'https://api.thecompaniesapi.com/v2/locations/cities';
//     $token = 'QkOk9xpTQwSDEvmD06dt7fD8SzNbr5ar';
//     $page = 1;

//     $response = Http::get($baseUrl, [
//             'token' => $token,
//             'page' => $page,
//         ]);

//         $dataResponse = $response->json();

//         foreach ($dataResponse['cities'] as $city) {
//             $Cities = [
//                 'code' => $city['code'],
//                 'ville' => $city['name'],
//                 'pays' => $city['country']['nameFr'],
                
//             ];
//             $meta = $dataResponse['meta'];

//             $allCities[] = $Cities;
//         }
//         $allCities['meta'] = $meta;
        
//         // 
        
//     do {
        

//         if (!isset($dataResponse['cities']) || !is_array($dataResponse['cities'])) {
//             break;
//         }

//         $allCities = array_merge($allCities, $dataResponse['cities']);

//         $currentPage = $data['meta']['currentPage'] ?? $page;
//         $lastPage = $data['meta']['lastPage'] ?? $page;
//         $page++;

//     } while ($currentPage < $lastPage);

//     $countries = collect($allCities)
//         // ->pluck('state')
//         ->filter()
//         ->unique()
//         ->values();

//         return response()->json($countries);
//     });

Route::get('api/cities', function () {
    $allCities = [];

    $baseUrl = 'https://api.thecompaniesapi.com/v2/locations/cities';
    $token = 'QkOk9xpTQwSDEvmD06dt7fD8SzNbr5ar';
    $page = 1;
    $lastPage = 1;

    do {
        $response = Http::get($baseUrl, [
            'token' => $token,
            'page' => $page,
        ]);

        $dataResponse = $response->json();

        if (!isset($dataResponse['cities']) || !is_array($dataResponse['cities'])) {
            break;
        }

        foreach ($dataResponse['cities'] as $city) {
            $allCities[] = [
                'code' => $city['code'] ?? null,
                'ville' => $city['name'] ?? null,
                'pays' => $city['country']['nameFr'] ?? null,
            ];
        }

        $currentPage = $dataResponse['meta']['currentPage'] ?? $page;
        $lastPage = $dataResponse['meta']['lastPage'] ?? $page;

        $page++;
    } while ($currentPage < $lastPage);

    // Retourne toutes les villes sans la pagination
    return response()->json($allCities);
    // afficher les villes dont le pays est Côte d'Ivoire
    // $filteredCities = collect($allCities)
    //     ->filter(function ($city) {
    //         return $city['pays'] == 'Côte d\'Ivoire';
    //     })
    //     ->values();

    // return response()->json($filteredCities);
    
});
    // return response()->json($dataResponse);
    // return response()->json($data);

// $data = [
        //     'code' => $dataResponse['cities']['code'],
        //     'pays' => $dataResponse['cities']['country'],
        //     'meta' => $dataResponse['meta'],
        // ];