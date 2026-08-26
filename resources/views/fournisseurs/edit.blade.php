@extends('layouts.app')

@section('title', 'Modifier le fournisseur')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-6">Modifier « {{ $fournisseur->nom }} »</h1>

    <form method="POST" action="{{ route('fournisseurs.update', $fournisseur) }}" class="space-y-4">
        @csrf
        @method('PUT')
        @include('fournisseurs._form')

        <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">
            Enregistrer
        </button>
    </form>
</div>
@endsection
