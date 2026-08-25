<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        // v0.1 : tout utilisateur connecté peut créer un produit.
        // Les rôles/permissions arrivent en v0.2.
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:150'],
            'sku' => ['required', 'string', 'max:50', 'unique:produits,sku'],
            'description' => ['nullable', 'string'],
            'prix_unitaire' => ['required', 'numeric', 'min:0'],
            'quantite_stock' => ['required', 'integer', 'min:0'],
            'seuil_alerte' => ['required', 'integer', 'min:0'],
        ];
    }
}
