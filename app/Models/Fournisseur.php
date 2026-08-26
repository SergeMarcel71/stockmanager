<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fournisseur extends Model
{
    protected $fillable = [
        'nom',
        'contact',
        'email',
        'telephone',
        'delai_livraison_jours',
    ];

    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class);
    }
}
