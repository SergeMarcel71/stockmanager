@extends('layouts.app')

@section('title', 'Produits')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Inventaire</h1>
    <div class="flex gap-2">
        @can('create', App\Models\Produit::class)
            <a href="{{ route('produits.import') }}"
               class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded hover:bg-slate-50">
                Importer (CSV)
            </a>
            <a href="{{ route('produits.create') }}"
               class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700">
                + Nouveau produit
            </a>
        @endcan
    </div>
</div>

@if (session('error'))
    <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-3">{{ session('error') }}</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">Nom</th>
                <th class="px-4 py-3">SKU</th>
                <th class="px-4 py-3">Fournisseur</th>
                <th class="px-4 py-3 text-right">Prix</th>
                <th class="px-4 py-3 text-right">Stock</th>
                <th class="px-4 py-3">Statut</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produits as $produit)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $produit->nom }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $produit->sku }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $produit->fournisseur?->nom ?? '—' }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($produit->prix_unitaire, 2) }} €</td>
                    <td class="px-4 py-3 text-right">{{ $produit->quantite_stock }}</td>
                    <td class="px-4 py-3">
                        @if ($produit->estEnAlerte())
                            <span class="text-red-600 font-medium">⚠️ Alerte</span>
                        @else
                            <span class="text-green-600">OK</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ route('mouvements.create', $produit) }}" class="text-slate-700">Mouvement</a>
                        @can('update', $produit)
                            <a href="{{ route('produits.edit', $produit) }}" class="text-blue-600">Modifier</a>
                        @endcan
                        @can('delete', $produit)
                            <form method="POST" action="{{ route('produits.destroy', $produit) }}" class="inline"
                                  onsubmit="return confirm('Supprimer ce produit ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Supprimer</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                        Aucun produit pour l'instant.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $produits->links() }}
</div>
@endsection
