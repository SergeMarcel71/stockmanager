<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function index(): View
    {
        // Pagination pour respecter le critère d'acceptation du cahier des charges (§9)
        $produits = Produit::orderBy('nom')->paginate(15);

        return view('produits.index', compact('produits'));
    }

    public function create(): View
    {
        return view('produits.create');
    }

    public function store(StoreProduitRequest $request): RedirectResponse
    {
        Produit::create($request->validated());

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Produit $produit): View
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(UpdateProduitRequest $request, Produit $produit): RedirectResponse
    {
        $produit->update($request->validated());

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        $produit->delete();

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit supprimé.');
    }
}
