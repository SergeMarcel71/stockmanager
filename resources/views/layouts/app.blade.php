<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockManager — @yield('title', 'Accueil')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    @auth
    <nav class="bg-slate-800 text-white px-6 py-3 flex justify-between items-center">
        <a href="{{ route('produits.index') }}" class="font-semibold text-lg">📦 StockManager</a>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-300">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-300 hover:text-white">Déconnexion</button>
            </form>
        </div>
    </nav>
    @endauth

    <main class="max-w-5xl mx-auto px-6 py-8">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
