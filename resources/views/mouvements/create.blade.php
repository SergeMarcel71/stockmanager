@extends('layouts.app')

@section('title', 'Mouvement de stock')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-1">Mouvement de stock</h1>
    <p class="text-sm text-gray-500 mb-6">
        {{ $produit->nom }} — stock actuel : <strong>{{ $produit->quantite_stock }}</strong>
    </p>

    @if (session('error'))
        <div class="mb-4 text-sm text-red-600 bg-red-50 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('mouvements.store', $produit) }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Type de mouvement</label>
            <select name="type" required class="w-full border rounded px-3 py-2">
                <option value="entree">Entrée (réception de marchandise)</option>
                <option value="sortie">Sortie (remise à un utilisateur)</option>
                <option value="ajustement">Ajustement (casse / perte constatée)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Quantité</label>
            <input type="number" name="quantite" min="1" required value="{{ old('quantite') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Motif (optionnel)</label>
            <input type="text" name="motif" value="{{ old('motif') }}"
                   placeholder="Ex : livraison TechDistrib du 12/01"
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">
            Enregistrer le mouvement
        </button>
    </form>

    @if ($produit->mouvements->isNotEmpty())
        <div class="mt-8">
            <h2 class="text-sm font-semibold text-gray-500 mb-2">Historique récent</h2>
            <ul class="text-sm divide-y">
                @foreach ($produit->mouvements->take(10) as $mouvement)
                    <li class="py-2 flex justify-between">
                        <span>{{ $mouvement->libelle() }}</span>
                        <span class="text-gray-400">{{ $mouvement->date_mouvement->format('d/m/Y H:i') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
