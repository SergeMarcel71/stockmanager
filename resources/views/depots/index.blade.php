@extends('layouts.app')

@section('title', 'Dépôts')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Dépôts</h1>
    <div class="flex gap-2">
        <a href="{{ route('depots.assigner') }}" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded hover:bg-slate-50">
            Affecter des utilisateurs
        </a>
        <a href="{{ route('depots.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700">
            + Nouveau dépôt
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">Nom</th>
                <th class="px-4 py-3">Adresse</th>
                <th class="px-4 py-3 text-right">Utilisateurs rattachés</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($depots as $depot)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $depot->nom }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $depot->adresse ?? '—' }}</td>
                    <td class="px-4 py-3 text-right">{{ $depot->utilisateurs_count }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('depots.edit', $depot) }}" class="text-blue-600">Modifier</a>
                        <form method="POST" action="{{ route('depots.destroy', $depot) }}" class="inline"
                              onsubmit="return confirm('Supprimer ce dépôt ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Aucun dépôt.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
