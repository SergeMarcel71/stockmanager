<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFournisseurRequest;
use App\Models\Fournisseur;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FournisseurController extends Controller
{
    public function index(): View
    {
        $this->authorize('fournisseurs.gerer');

        $fournisseurs = Fournisseur::withCount('produits')->orderBy('nom')->paginate(15);

        return view('fournisseurs.index', compact('fournisseurs'));
    }

    public function create(): View
    {
        $this->authorize('fournisseurs.gerer');

        return view('fournisseurs.create');
    }

    public function store(StoreFournisseurRequest $request): RedirectResponse
    {
        Fournisseur::create($request->validated());

        return redirect()
            ->route('fournisseurs.index')
            ->with('success', 'Fournisseur ajouté.');
    }

    public function edit(Fournisseur $fournisseur): View
    {
        $this->authorize('fournisseurs.gerer');

        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(StoreFournisseurRequest $request, Fournisseur $fournisseur): RedirectResponse
    {
        $fournisseur->update($request->validated());

        return redirect()
            ->route('fournisseurs.index')
            ->with('success', 'Fournisseur mis à jour.');
    }

    public function destroy(Fournisseur $fournisseur): RedirectResponse
    {
        $this->authorize('fournisseurs.gerer');

        $fournisseur->delete();

        return redirect()
            ->route('fournisseurs.index')
            ->with('success', 'Fournisseur supprimé.');
    }
}
