<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\MouvementStock;
use App\Models\Produit;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Produit::class);

        $valeurTotaleStock = Produit::query()
            ->selectRaw('SUM(prix_unitaire * quantite_stock) as total')
            ->value('total') ?? 0;

        $produitsEnAlerte = Produit::whereColumn('quantite_stock', '<=', 'seuil_alerte')
            ->orderBy('quantite_stock')
            ->get();

        // "Produits dormants" du Module E : jamais eu de mouvement de type sortie
        $produitsDormants = Produit::whereDoesntHave('mouvements', function ($query) {
            $query->where('type', 'sortie');
        })->count();

        $valeurParCategorie = Categorie::query()
            ->withSum('produits as valeur_stock', 'prix_unitaire')
            ->get()
            ->map(function ($categorie) {
                // withSum multiplie mal deux colonnes ensemble, donc on recalcule proprement ici
                $valeur = $categorie->produits()
                    ->selectRaw('SUM(prix_unitaire * quantite_stock) as total')
                    ->value('total') ?? 0;

                return [
                    'nom' => $categorie->nom,
                    'valeur' => (float) $valeur,
                ];
            });

        $mouvementsRecents = MouvementStock::with(['produit:id,nom', 'utilisateur:id,name'])
            ->latest('date_mouvement')
            ->limit(10)
            ->get();

        return view('dashboard', [
            'valeurTotaleStock' => (float) $valeurTotaleStock,
            'produitsEnAlerte' => $produitsEnAlerte,
            'produitsDormants' => $produitsDormants,
            'valeurParCategorie' => $valeurParCategorie,
            'mouvementsRecents' => $mouvementsRecents,
            'nombreProduits' => Produit::count(),
        ]);
    }
}
