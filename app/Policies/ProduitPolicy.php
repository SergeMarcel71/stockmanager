<?php

namespace App\Policies;

use App\Models\Produit;
use App\Models\User;

class ProduitPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('produits.voir');
    }

    public function create(User $user): bool
    {
        return $user->can('produits.gerer');
    }

    public function update(User $user, Produit $produit): bool
    {
        return $user->can('produits.gerer');
    }

    public function delete(User $user, Produit $produit): bool
    {
        return $user->can('produits.gerer');
    }
}
