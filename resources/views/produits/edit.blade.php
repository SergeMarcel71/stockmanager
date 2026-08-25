@extends('layouts.app')

@section('title', 'Modifier le produit')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-6">Modifier « {{ $produit->nom }} »</h1>

    <form method="POST" action="{{ route('produits.update', $produit) }}" class="space-y-4">
        @csrf
        @method('PUT')
        @include('produits._form')

        <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">
            Enregistrer les modifications
        </button>
    </form>
</div>
@endsection
