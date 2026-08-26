<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MouvementStock extends Model
{
    protected $table = 'mouvements_stock';
    protected $fillable = [
        'produit_id',
        'utilisateur_id',
        'type',
        'quantite',
        'motif',
        'date_mouvement',
    ];

    protected $casts = [
        'date_mouvement' => 'datetime',
    ];

    /**
     * Règle de gestion du cahier des charges (§5.2) :
     * un mouvement est immuable, on ne le modifie/supprime jamais après coup.
     * On désactive volontairement les méthodes de mise à jour/suppression Eloquent.
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        throw new \LogicException('Un mouvement de stock est immuable : impossible de le modifier.');
    }

    public function delete(): ?bool
    {
        throw new \LogicException('Un mouvement de stock est immuable : impossible de le supprimer.');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function libelle(): string
    {
        return match ($this->type) {
            'entree' => "Entrée de {$this->quantite} unités",
            'sortie' => "Sortie de {$this->quantite} unités",
            'transfert' => "Transfert de {$this->quantite} unités",
            'ajustement' => "Ajustement de {$this->quantite} unités",
            default => "Mouvement de {$this->quantite} unités",
        };
    }
}
