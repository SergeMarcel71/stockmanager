<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepotRequest;
use App\Models\Depot;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepotController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $depots = Depot::withCount('utilisateurs')->orderBy('nom')->get();

        return view('depots.index', compact('depots'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        return view('depots.create');
    }

    public function store(StoreDepotRequest $request): RedirectResponse
    {
        Depot::create($request->validated());

        return redirect()->route('depots.index')->with('success', 'Dépôt créé.');
    }

    public function edit(Depot $depot): View
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        return view('depots.edit', compact('depot'));
    }

    public function update(StoreDepotRequest $request, Depot $depot): RedirectResponse
    {
        $depot->update($request->validated());

        return redirect()->route('depots.index')->with('success', 'Dépôt mis à jour.');
    }

    public function destroy(Depot $depot): RedirectResponse
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $depot->delete();

        return redirect()->route('depots.index')->with('success', 'Dépôt supprimé.');
    }

    /**
     * Affecter un dépôt à un utilisateur (page simple, dédiée à l'admin).
     */
    public function assignerForm(): View
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        return view('depots.assigner', [
            'utilisateurs' => User::with('depot')->orderBy('name')->get(),
            'depots' => Depot::orderBy('nom')->get(),
        ]);
    }

    public function assigner(User $utilisateur): RedirectResponse
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $data = request()->validate([
            'depot_id' => ['nullable', 'exists:depots,id'],
        ]);

        $utilisateur->update(['depot_id' => $data['depot_id'] ?? null]);

        return redirect()->route('depots.assigner')->with('success', "Dépôt mis à jour pour {$utilisateur->name}.");
    }
}
