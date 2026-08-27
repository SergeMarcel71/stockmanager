<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMouvementStockRequest;
use App\Models\Produit;
use App\Services\StockMovementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MouvementStockController extends Controller
{
    public function __construct(private StockMovementService $stockMovementService)
    {
    }

    public function index(Produit $produit): JsonResponse
    {
        return response()->json(
            $produit->mouvements()->with('utilisateur:id,name')->paginate(20)
        );
    }

    public function store(StoreMouvementStockRequest $request, Produit $produit): JsonResponse
    {
        $mouvement = $this->stockMovementService->enregistrer(
            produit: $produit,
            type: $request->validated('type'),
            quantite: (int) $request->validated('quantite'),
            motif: $request->validated('motif'),
            utilisateur: $request->user(),
        );

        if ($mouvement === null) {
            return response()->json([
                'message' => 'Mouvement refusé : quantité insuffisante en stock.',
            ], 422);
        }

        return response()->json($mouvement, 201);
    }
}
