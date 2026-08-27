<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:150'],
            'adresse' => ['nullable', 'string', 'max:255'],
        ];
    }
}
