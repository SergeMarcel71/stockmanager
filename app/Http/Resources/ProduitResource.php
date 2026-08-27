<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
{
    /**
     * Transforme le modèle Eloquent en tableau JSON propre.
     * C'est ici qu'on choisit exactement ce qu'on expose à l'extérieur
     * (par exemple, on pourrait vouloir cacher certains champs internes).
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'sku' => $this->sku,
            'description' => $this->description,
            'prix_unitaire' => (float) $this->prix_unitaire,
            'quantite_stock' => $this->quantite_stock,
            'seuil_alerte' => $this->seuil_alerte,
            'en_alerte' => $this->estEnAlerte(),
            'valeur_stock' => $this->valeurStock(),
            'categorie' => $this->whenLoaded('categorie', fn () => [
                'id' => $this->categorie->id,
                'nom' => $this->categorie->nom,
            ]),
            'fournisseur' => $this->whenLoaded('fournisseur', fn () => [
                'id' => $this->fournisseur->id,
                'nom' => $this->fournisseur->nom,
            ]),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
