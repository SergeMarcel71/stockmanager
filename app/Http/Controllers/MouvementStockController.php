<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMouvementStockRequest;
use App\Models\Produit;
use App\Services\StockMovementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MouvementStockController extends Controller
{
    public function __construct(private StockMovementService $stockMovementService)
    {
    }

    public function create(Produit $produit): View
    {
        $this->authorize('mouvements.creer');

        return view('mouvements.create', compact('produit'));
    }

    public function store(StoreMouvementStockRequest $request, Produit $produit): RedirectResponse
    {
        $mouvement = $this->stockMovementService->enregistrer(
            produit: $produit,
            type: $request->validated('type'),
            quantite: (int) $request->validated('quantite'),
            motif: $request->validated('motif'),
            utilisateur: $request->user(),
        );

        if ($mouvement === null) {
            return back()
                ->withInput()
                ->with('error', 'Mouvement refusé : quantité insuffisante en stock pour cette opération.');
        }

        return redirect()
            ->route('produits.index')
            ->with('success', 'Mouvement de stock enregistré : ' . $mouvement->libelle());
    }
}
