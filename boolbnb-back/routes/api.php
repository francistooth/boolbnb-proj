<?php

use App\Http\Controllers\Admin\ApartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SendMessageController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::get('/appartamenti', [PageController::class, 'allApartments']);
Route::get('/dettaglio/{slug}', [PageController::class, 'apartment']);
Route::get('/filtro-servizi/{slug}', [PageController::class, 'servicesApt']);
Route::get('/servizi', [PageController::class, 'service']);
Route::post('/messaggi', [SendMessageController::class, 'store']);
Route::post('/appartamenti-nel-raggio', [PageController::class, 'getApartmentsInRange']);
Route::post('/user', [PageController::class, 'getUser']);
