@extends('layouts.app')

@section('title', 'Modifier le dépôt')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-6">Modifier « {{ $depot->nom }} »</h1>

    <form method="POST" action="{{ route('depots.update', $depot) }}" class="space-y-4">
        @csrf
        @method('PUT')
        @include('depots._form')

        <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">
            Enregistrer
        </button>
    </form>
</div>
@endsection
