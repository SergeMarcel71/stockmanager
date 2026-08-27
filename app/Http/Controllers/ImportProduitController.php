<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportProduitsRequest;
use App\Jobs\ImporterProduitsJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ImportProduitController extends Controller
{
    public function create(): View
    {
        $this->authorize('create', \App\Models\Produit::class);

        return view('produits.import');
    }

    public function store(ImportProduitsRequest $request): RedirectResponse
    {
        // On stocke le fichier de façon privée (storage/app/imports/...), le Job le lira puis le supprimera
        $chemin = $request->file('fichier')->store('imports');

        ImporterProduitsJob::dispatch($chemin, $request->user()->id);

        return redirect()
            ->route('produits.index')
            ->with('success', "Import lancé en arrière-plan. Tu recevras un email (visible sur Mailpit) une fois terminé.");
    }
}
