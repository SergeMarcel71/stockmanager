@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-sm text-gray-500">Valeur totale du stock</p>
        <p class="text-2xl font-semibold mt-1">{{ number_format($valeurTotaleStock, 2) }} €</p>
    </div>
    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-sm text-gray-500">Produits référencés</p>
        <p class="text-2xl font-semibold mt-1">{{ $nombreProduits }}</p>
    </div>
    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-sm text-gray-500">Produits en alerte</p>
        <p class="text-2xl font-semibold mt-1 text-red-600">{{ $produitsEnAlerte->count() }}</p>
    </div>
    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-sm text-gray-500">Produits dormants</p>
        <p class="text-2xl font-semibold mt-1 text-amber-600">{{ $produitsDormants }}</p>
        <p class="text-xs text-gray-400 mt-1">jamais sortis du stock</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="font-semibold mb-4">Valeur du stock par catégorie</h2>
        <canvas id="chartCategories" height="220"></canvas>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="font-semibold mb-4">Produits en alerte</h2>
        @if ($produitsEnAlerte->isEmpty())
            <p class="text-sm text-gray-400">Aucun produit en alerte actuellement.</p>
        @else
            <ul class="text-sm divide-y">
                @foreach ($produitsEnAlerte as $produit)
                    <li class="py-2 flex justify-between">
                        <span>{{ $produit->nom }}</span>
                        <span class="text-red-600">{{ $produit->quantite_stock }} / seuil {{ $produit->seuil_alerte }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow mt-6">
    <h2 class="font-semibold mb-4">Mouvements récents</h2>
    @if ($mouvementsRecents->isEmpty())
        <p class="text-sm text-gray-400">Aucun mouvement pour l'instant.</p>
    @else
        <ul class="text-sm divide-y">
            @foreach ($mouvementsRecents as $mouvement)
                <li class="py-2 flex justify-between">
                    <span>{{ $mouvement->produit->nom }} — {{ $mouvement->libelle() }}</span>
                    <span class="text-gray-400">
                        {{ $mouvement->utilisateur->name }} · {{ $mouvement->date_mouvement->format('d/m H:i') }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('chartCategories');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($valeurParCategorie->pluck('nom')),
            datasets: [{
                label: 'Valeur du stock (€)',
                data: @json($valeurParCategorie->pluck('valeur')),
                backgroundColor: '#1e293b',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush
@endsection
