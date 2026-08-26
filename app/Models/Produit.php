<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'sku',
        'description',
        'categorie_id',
        'fournisseur_id',
        'prix_unitaire',
        'quantite_stock',
        'seuil_alerte',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'quantite_stock' => 'integer',
        'seuil_alerte' => 'integer',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(MouvementStock::class)->latest('date_mouvement');
    }

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
