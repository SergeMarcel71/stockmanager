<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMouvementStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('mouvements.creer');
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:entree,sortie,ajustement'],
            'quantite' => ['required', 'integer', 'min:1'],
            'motif' => ['nullable', 'string', 'max:255'],
        ];
    }
}
