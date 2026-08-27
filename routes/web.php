<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ImportProduitController;
use App\Http\Controllers\MouvementStockController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produits', ProduitController::class)->except('show');
    Route::resource('fournisseurs', FournisseurController::class)->except('show');
    Route::resource('depots', DepotController::class)->except('show');

    Route::get('depots-assigner', [DepotController::class, 'assignerForm'])->name('depots.assigner');
    Route::post('depots-assigner/{utilisateur}', [DepotController::class, 'assigner'])->name('depots.assigner.store');

    Route::get('produits/{produit}/mouvements/create', [MouvementStockController::class, 'create'])
        ->name('mouvements.create');
    Route::post('produits/{produit}/mouvements', [MouvementStockController::class, 'store'])
        ->name('mouvements.store');

    Route::get('produits-import', [ImportProduitController::class, 'create'])->name('produits.import');
    Route::post('produits-import', [ImportProduitController::class, 'store'])->name('produits.import.store');
});
