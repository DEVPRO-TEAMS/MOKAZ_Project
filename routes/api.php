<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Partner\PartnerController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\Properties\AppartController;
use App\Http\Controllers\Properties\PropertyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// parametrage

Route::post('/variable/store', [SettingController::class, 'storeVariable'])->name('storeVariable');

// reservations 








Route::get('setting/index/propertiesTypes', [SettingController::class, 'propertiesTypes'])->name('index.propertiesTypes');
Route::post('setting/store/propertyType', [SettingController::class, 'storePropertyType'])->name('store.propertyType');
Route::post('setting/update/{id}/propertyType', [SettingController::class, 'updatePropertyType'])->name('update.propertyType');
Route::delete('setting/destroy/{id}/propertyType', [SettingController::class, 'destroyPropertyType'])->name('destroy.propertyType');

Route::post('partner/demande/store', [PartnerController::class, 'store']);
Route::post('/partnership/accept/{id}', [AdminController::class, 'accepterDemande']);
Route::post('/demande/rejet/{id}', [AdminController::class, 'rejetDemande'])->name('api.rejet.demande');




Route::get('/get-cities-by-country', [PropertyController::class, 'getCities']);

// api property
Route::post('/property/add', [PropertyController::class, 'store']);
Route::post('/property/destroy{uuid}', [PropertyController::class, 'destroy']);
Route::get('/get-all-properties', [PagesController::class, 'getAllProperties']);

// api appartements
Route::post('/appart/add', [AppartController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
