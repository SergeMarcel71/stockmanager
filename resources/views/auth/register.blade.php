@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="max-w-sm mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-6">Créer un compte</h1>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input type="password" name="password" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">
            S'inscrire
        </button>
    </form>

    <p class="text-sm text-center mt-4">
        Déjà un compte ? <a href="{{ route('login') }}" class="text-blue-600">Se connecter</a>
    </p>
</div>
@endsection
