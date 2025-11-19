<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndicateurRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'typeIndicateur_id'=>'required|integer',
            'anneeAcademique_id'=>'required|integer',
            'libelle'=>'required',
            'date_echeance'=>'required|date',
            'public'=>'boolean',
        ];
    }
}
