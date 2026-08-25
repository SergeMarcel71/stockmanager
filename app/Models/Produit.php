<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    // Les champs qu'on autorise à remplir via un formulaire (protection contre l'injection de champs non voulus)
    protected $fillable = [
        'nom',
        'sku',
        'description',
        'prix_unitaire',
        'quantite_stock',
        'seuil_alerte',
    ];

    // Conversion automatique des types quand on lit/écrit ces colonnes
    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'quantite_stock' => 'integer',
        'seuil_alerte' => 'integer',
    ];

    /**
     * Règle de gestion du cahier des charges (§5.1) :
     * un produit ne peut jamais avoir une quantité négative.
     */
    public function retirerStock(int $quantite): bool
    {
        if ($quantite <= 0 || $quantite > $this->quantite_stock) {
            return false;
        }

        $this->decrement('quantite_stock', $quantite);

        return true;
    }

    public function ajouterStock(int $quantite): void
    {
        if ($quantite > 0) {
            $this->increment('quantite_stock', $quantite);
        }
    }

    public function estEnAlerte(): bool
    {
        return $this->quantite_stock <= $this->seuil_alerte;
    }

    public function valeurStock(): float
    {
        return (float) $this->prix_unitaire * $this->quantite_stock;
    }
}
