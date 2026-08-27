@extends('layouts.app')

@section('title', 'Import de produits')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-2">Importer des produits (CSV)</h1>
    <p class="text-sm text-gray-500 mb-6">
        L'import se fait en arrière-plan (Job asynchrone) : tu n'attends pas que ça se termine,
        une notification t'arrive une fois le traitement fini.
    </p>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="mb-6 bg-gray-50 border rounded p-4 text-xs text-gray-600">
        <p class="font-medium mb-1">Format attendu (avec en-tête) :</p>
        <code>nom,sku,prix_unitaire,quantite_stock,seuil_alerte,categorie,fournisseur</code>
        <p class="mt-2">Exemple :</p>
        <code>Clavier mécanique,CLA-099,45.90,20,5,Périphériques,TechDistrib</code>
    </div>

    <form method="POST" action="{{ route('produits.import.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Fichier CSV</label>
            <input type="file" name="fichier" accept=".csv,.txt" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">
            Lancer l'import
        </button>
    </form>
</div>
@endsection
