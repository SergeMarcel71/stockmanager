<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Http\Resources\ProduitResource;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * GET /api/produits
     * Supporte des filtres optionnels : ?en_alerte=1, ?categorie_id=2
     */
    public function index(Request $request): JsonResponse
    {
        $query = Produit::with(['categorie', 'fournisseur']);

        if ($request->boolean('en_alerte')) {
            $query->whereColumn('quantite_stock', '<=', 'seuil_alerte');
        }

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->integer('categorie_id'));
        }

        $produits = $query->orderBy('nom')->paginate(20);

        return ProduitResource::collection($produits)->response();
    }

    public function show(Produit $produit): JsonResponse
    {
        $produit->load(['categorie', 'fournisseur']);

        return (new ProduitResource($produit))->response();
    }

    public function store(StoreProduitRequest $request): JsonResponse
    {
        $produit = Produit::create($request->validated());

        return (new ProduitResource($produit))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateProduitRequest $request, Produit $produit): JsonResponse
    {
        $produit->update($request->validated());

        return (new ProduitResource($produit))->response();
    }

    public function destroy(Produit $produit): JsonResponse
    {
        $this->authorize('delete', $produit);

        $produit->delete();

        return response()->json(null, 204);
    }
}
