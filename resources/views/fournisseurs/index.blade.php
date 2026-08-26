@extends('layouts.app')

@section('title', 'Fournisseurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Fournisseurs</h1>
    <a href="{{ route('fournisseurs.create') }}"
       class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700">
        + Nouveau fournisseur
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">Nom</th>
                <th class="px-4 py-3">Contact</th>
                <th class="px-4 py-3">Délai livraison</th>
                <th class="px-4 py-3 text-right">Produits liés</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fournisseurs as $fournisseur)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $fournisseur->nom }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $fournisseur->contact ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $fournisseur->delai_livraison_jours }} jours</td>
                    <td class="px-4 py-3 text-right">{{ $fournisseur->produits_count }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="text-blue-600">Modifier</a>
                        <form method="POST" action="{{ route('fournisseurs.destroy', $fournisseur) }}" class="inline"
                              onsubmit="return confirm('Supprimer ce fournisseur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun fournisseur.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $fournisseurs->links() }}</div>
@endsection
