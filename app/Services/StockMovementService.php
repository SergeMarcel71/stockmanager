<?php

namespace App\Services;

use App\Models\MouvementStock;
use App\Models\Produit;
use App\Models\User;
use App\Notifications\StockBasNotification;
use Illuminate\Support\Facades\DB;

class StockMovementService
{
    public function enregistrer(
        Produit $produit,
        string $type,
        int $quantite,
        ?string $motif,
        User $utilisateur
    ): ?MouvementStock {
        return DB::transaction(function () use ($produit, $type, $quantite, $motif, $utilisateur) {
            $succes = match ($type) {
                'entree' => $this->appliquerEntree($produit, $quantite),
                'sortie' => $this->appliquerSortie($produit, $quantite),
                'ajustement' => $this->appliquerAjustement($produit, $quantite),
                default => false,
            };

            if (! $succes) {
                DB::rollBack();
                return null;
            }

            $mouvement = MouvementStock::create([
                'produit_id' => $produit->id,
                // Le dépôt n'est jamais choisi manuellement dans le formulaire :
                // il est déduit automatiquement du dépôt actif de l'utilisateur qui agit.
                'depot_id' => $utilisateur->depot_id,
                'utilisateur_id' => $utilisateur->id,
                'type' => $type,
                'quantite' => $quantite,
                'motif' => $motif,
                'date_mouvement' => now(),
            ]);

            if ($produit->fresh()->estEnAlerte()) {
                $utilisateur->notify(new StockBasNotification($produit->fresh()));
            }

            return $mouvement;
        });
    }

    private function appliquerEntree(Produit $produit, int $quantite): bool
    {
        $produit->ajouterStock($quantite);

        return true;
    }

    private function appliquerSortie(Produit $produit, int $quantite): bool
    {
        return $produit->retirerStock($quantite);
    }

    private function appliquerAjustement(Produit $produit, int $quantite): bool
    {
        return $produit->retirerStock($quantite);
    }
}
