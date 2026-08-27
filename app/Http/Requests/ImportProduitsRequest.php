<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProduitsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('produits.gerer');
    }

    public function rules(): array
    {
        return [
            'fichier' => ['required', 'file', 'mimes:csv,txt', 'max:5120'], // 5 Mo max
        ];
    }
}
