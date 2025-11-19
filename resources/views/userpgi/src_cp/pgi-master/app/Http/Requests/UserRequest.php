<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'email' => 'email|required|max:255|unique:users,email,NULL,id',
                        'nom' => 'required|max:225',
                        'prenom' => 'required|max:225',
                        'adresse' => 'nullable|max:225',
                        'telephone' => 'nullable|max:100',
                        'sexe' => 'required|max:100',
                        'date_naissance' => 'nullable|max:100',
                        'lieu_naissance' => 'nullable|max:100',
                        'ia' => 'nullable',
                        'ief' => 'nullable',
                        'photo_profil_path' => 'nullable|mimes:jpeg,png|dimensions:min_width=80,min_height=80,max_width=800,max_height=800',
                        'roles' => 'sometimes|array',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'email' => 'email|required|max:255|unique:users,email,' . $this->get('user_id') . ',id',
                        'nom' => 'required|max:225',
                        'prenom' => 'required|max:225',
                        'adresse' => 'nullable|max:225',
                        'sexe' => 'required|max:100',
                        'telephone' => 'nullable|max:100',
                        'date_naissance' => 'nullable|max:100',
                        'lieu_naissance' => 'nullable|max:100',
                        'ia' => 'nullable',
                        'ief' => 'nullable',
                        'photo_profil_path' => 'nullable|mimes:jpeg,png|dimensions:min_width=80,min_height=80,max_width=800,max_height=800',
                        'roles' => 'sometimes|array',
                    ];
                }
            default:
                break;
        }
    }
}
