@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="max-w-sm mx-auto bg-white p-8 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-6">Connexion</h1>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input type="password" name="password" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember">
            Se souvenir de moi
        </label>

        <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">
            Se connecter
        </button>
    </form>

    <p class="text-sm text-center mt-4">
        Pas encore de compte ? <a href="{{ route('register') }}" class="text-blue-600">S'inscrire</a>
    </p>
</div>
@endsection
