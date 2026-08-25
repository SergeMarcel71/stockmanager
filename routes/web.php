<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

// Redirection de la racine vers la liste des produits (ou le login si pas connecté)
Route::get('/', function () {
    return redirect()->route('produits.index');
});

// --- Routes invités uniquement (register/login) ---
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// --- Routes utilisateurs connectés uniquement ---
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Une seule ligne qui crée automatiquement les 7 routes CRUD standards
    // (index, create, store, show, edit, update, destroy)
    Route::resource('produits', ProduitController::class)->except('show');
});
