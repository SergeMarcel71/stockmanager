<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Produit::class);

        $produits = Produit::with(['categorie', 'fournisseur'])->orderBy('nom')->paginate(15);

        return view('produits.index', compact('produits'));
    }

    public function create(): View
    {
        $this->authorize('create', Produit::class);

        return view('produits.create', [
            'categories' => Categorie::orderBy('nom')->get(),
            'fournisseurs' => Fournisseur::orderBy('nom')->get(),
        ]);
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
        $this->authorize('update', $produit);

        return view('produits.edit', [
            'produit' => $produit,
            'categories' => Categorie::orderBy('nom')->get(),
            'fournisseurs' => Fournisseur::orderBy('nom')->get(),
        ]);
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
        $this->authorize('delete', $produit);

        $produit->delete();

        return redirect()
            ->route('produits.index')
            ->with('success', 'Produit supprimé.');
    }
}
