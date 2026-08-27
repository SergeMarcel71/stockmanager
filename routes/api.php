<?php

use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\MouvementStockController;
use App\Http\Controllers\Api\ProduitController;
use Illuminate\Support\Facades\Route;

// Pas besoin d'être authentifié pour obtenir un token
Route::post('token', [AuthTokenController::class, 'store']);

// Toutes les routes ci-dessous nécessitent un token Sanctum valide
// (en-tête HTTP : Authorization: Bearer {token})
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('token', [AuthTokenController::class, 'destroy']);

    Route::apiResource('produits', ProduitController::class);

    Route::get('produits/{produit}/mouvements', [MouvementStockController::class, 'index']);
    Route::post('produits/{produit}/mouvements', [MouvementStockController::class, 'store']);
});
