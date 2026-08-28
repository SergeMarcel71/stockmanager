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
        <div class="flex items-center gap-6">
            <a href="{{ route('produits.index') }}" class="font-semibold text-lg">📦 StockManager</a>
            <a href="{{ route('dashboard') }}" class="text-sm text-slate-300 hover:text-white">Dashboard</a>
            <a href="{{ route('produits.index') }}" class="text-sm text-slate-300 hover:text-white">Produits</a>
            @can('fournisseurs.gerer')
                <a href="{{ route('fournisseurs.index') }}" class="text-sm text-slate-300 hover:text-white">Fournisseurs</a>
            @endcan
            @role('admin')
                <a href="{{ route('depots.index') }}" class="text-sm text-slate-300 hover:text-white">Dépôts</a>
            @endrole
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-300">
                {{ auth()->user()->name }}
                <span class="text-slate-500">
                    ({{ auth()->user()->getRoleNames()->first() ?? 'sans rôle' }}@if(auth()->user()->depot) · {{ auth()->user()->depot->nom }} @endif)
                </span>
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-300 hover:text-white">Déconnexion</button>
            </form>
        </div>
    </nav>
    @endauth

    <!-- Zone où les alertes temps réel apparaissent, en haut à droite de l'écran -->
    <div id="alertes-temps-reel" class="fixed top-4 right-4 z-50 space-y-2 w-80"></div>

    <main class="max-w-5xl mx-auto px-6 py-8">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // window.Echo est défini dans resources/js/echo.js, importé dans app.js
            if (typeof window.Echo === 'undefined') {
                console.warn('Echo n\'est pas chargé — vérifie resources/js/app.js et le fichier .env (VITE_REVERB_*).');
                return;
            }

            window.Echo.channel('alertes-stock')
                .listen('.stock.bas', (evenement) => {
                    afficherAlerte(evenement);
                });

            function afficherAlerte(evenement) {
                const zone = document.getElementById('alertes-temps-reel');

                const carte = document.createElement('div');
                carte.className = 'bg-red-600 text-white rounded-lg shadow-lg p-4 text-sm animate-pulse';
                carte.innerHTML = `
                    <p class="font-semibold">⚠️ Stock bas</p>
                    <p>${evenement.nom} — ${evenement.quantite_stock} / seuil ${evenement.seuil_alerte}</p>
                `;

                zone.appendChild(carte);

                // Disparaît toute seule après 8 secondes
                setTimeout(() => carte.remove(), 8000);
            }
        });
    </script>
    @endauth

    @stack('scripts')
</body>
</html>
