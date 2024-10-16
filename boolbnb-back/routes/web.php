<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\Admin\UserResourceController;



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

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // TUTTE LE ROTTE DI Admin
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('apartments/trash', [ApartmentController::class, 'trash'])->name('apartments.trash');
        Route::patch('apartments/{id}/restore', [ApartmentController::class, 'restore'])->name('apartments.restore');
        Route::delete('apartments/{id}/delete', [ApartmentController::class, 'delete'])->name('apartments.delete');
        Route::resource('apartments', ApartmentController::class);
        Route::resource('user', UserResourceController::class)->except(['edit', 'update', 'destroy']);
    });

// guest routes

Route::get('/', [PageController::class, 'index'])->name('guest');

require __DIR__ . '/auth.php';
