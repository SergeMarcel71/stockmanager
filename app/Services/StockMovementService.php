<?php

namespace App\Services;

use App\Models\MouvementStock;
use App\Models\Produit;
use App\Models\User;
use App\Notifications\StockBasNotification;
use Illuminate\Support\Facades\DB;

class StockMovementService
{
    /**
     * Enregistre un mouvement de stock ET met à jour la quantité du produit,
     * de façon atomique (soit tout réussit, soit rien n'est appliqué).
     *
     * @return MouvementStock|null null si le mouvement a été refusé (ex: stock insuffisant)
     */
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
                // On annule la transaction : aucun mouvement n'est enregistré
                DB::rollBack();
                return null;
            }

            $mouvement = MouvementStock::create([
                'produit_id' => $produit->id,
                'utilisateur_id' => $utilisateur->id,
                'type' => $type,
                'quantite' => $quantite,
                'motif' => $motif,
                'date_mouvement' => now(),
            ]);

            // Règle de gestion : notifier si le mouvement fait passer le produit sous le seuil
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
        // Un ajustement peut représenter une casse/perte constatée : on retire du stock,
        // mais on l'autorise même si ça ramène exactement à 0 (jamais en dessous).
        return $produit->retirerStock($quantite);
    }
}
