<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $produit = $this->route('produit');

        return [
            'nom' => ['required', 'string', 'max:150'],
            // unique, sauf pour la ligne du produit qu'on est en train de modifier
            'sku' => ['required', 'string', 'max:50', 'unique:produits,sku,' . $produit->id],
            'description' => ['nullable', 'string'],
            'prix_unitaire' => ['required', 'numeric', 'min:0'],
            'quantite_stock' => ['required', 'integer', 'min:0'],
            'seuil_alerte' => ['required', 'integer', 'min:0'],
        ];
    }
}
