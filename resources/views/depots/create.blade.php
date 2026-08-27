@extends('layouts.app')

@section('title', 'Nouveau dépôt')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-6">Nouveau dépôt</h1>

    <form method="POST" action="{{ route('depots.store') }}" class="space-y-4">
        @csrf
        @include('depots._form')

        <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">
            Créer le dépôt
        </button>
    </form>
</div>
@endsection
