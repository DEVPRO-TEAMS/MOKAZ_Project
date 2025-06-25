<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Partner\PartnerController;

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
    Route::middleware('guest')->group(function(){
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('index');

        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('user')->name('user.')->group(function(){
    Route::middleware('guest')->group(function(){

    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('index');
    });
});

Route::prefix('partner')->name('partner.')->group(function(){
    Route::middleware('guest')->group(function(){
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [PartnerController::class, 'index'])->name('index');
    });
});