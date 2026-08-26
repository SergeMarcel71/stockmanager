<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('produits.gerer');
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:150'],
            'sku' => ['required', 'string', 'max:50', 'unique:produits,sku'],
            'description' => ['nullable', 'string'],
            'categorie_id' => ['nullable', 'exists:categories,id'],
            'fournisseur_id' => ['nullable', 'exists:fournisseurs,id'],
            'prix_unitaire' => ['required', 'numeric', 'min:0'],
            'quantite_stock' => ['required', 'integer', 'min:0'],
            'seuil_alerte' => ['required', 'integer', 'min:0'],
        ];
    }
}
