<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\MouvementStockController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('produits.index');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::resource('produits', ProduitController::class)->except('show');
    Route::resource('fournisseurs', FournisseurController::class)->except('show');

    // Mouvement de stock : imbriqué sous un produit précis
    // GET  /produits/{produit}/mouvements/create
    // POST /produits/{produit}/mouvements
    Route::get('produits/{produit}/mouvements/create', [MouvementStockController::class, 'create'])
        ->name('mouvements.create');
    Route::post('produits/{produit}/mouvements', [MouvementStockController::class, 'store'])
        ->name('mouvements.store');
});
