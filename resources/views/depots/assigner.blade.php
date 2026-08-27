@extends('layouts.app')

@section('title', 'Affecter les dépôts')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Affecter un dépôt aux utilisateurs</h1>

<p class="text-sm text-gray-500 mb-6">
    Le dépôt affecté à un utilisateur détermine automatiquement dans quel dépôt
    ses futurs mouvements de stock seront enregistrés — l'utilisateur n'a rien à choisir lui-même.
</p>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">Utilisateur</th>
                <th class="px-4 py-3">Rôle</th>
                <th class="px-4 py-3">Dépôt actif</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($utilisateurs as $utilisateur)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $utilisateur->name }} <span class="text-gray-400">({{ $utilisateur->email }})</span></td>
                    <td class="px-4 py-3 text-gray-500">{{ $utilisateur->getRoleNames()->first() ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('depots.assigner.store', $utilisateur) }}"
                              onchange="this.requestSubmit()">
                            @csrf
                            <select name="depot_id" class="border rounded px-2 py-1">
                                <option value="">— Aucun —</option>
                                @foreach ($depots as $depot)
                                    <option value="{{ $depot->id }}" @selected($utilisateur->depot_id === $depot->id)>
                                        {{ $depot->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
