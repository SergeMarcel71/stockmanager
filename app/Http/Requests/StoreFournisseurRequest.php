<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFournisseurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('fournisseurs.gerer');
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:150'],
            'contact' => ['nullable', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'delai_livraison_jours' => ['required', 'integer', 'min:0'],
        ];
    }
}
