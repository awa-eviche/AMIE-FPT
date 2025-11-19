<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Hamcrest\Arrays\IsArray;
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

                    $rules = [
                        'email' => 'email|required|max:255|unique:users,email,NULL,id',
                        'nom' => 'required|max:225',
                        'prenom' => 'required|max:225',
                        'adresse' => 'nullable|max:225',
                        'telephone' => 'required|max:100',
                        'sexe' => 'required|max:100',
                        'date_naissance' => 'nullable|max:100',
                        'lieu_naissance' => 'nullable|max:100',
                        'ia' => 'nullable',
                        'ief' => 'nullable',
                        'photo_profil_path' => 'nullable|mimes:jpeg,png|dimensions:min_width=80,min_height=80,max_width=800,max_height=800',
                        'roles' => 'sometimes|array',
                    ];

                    if (optional(auth()->user()->personnel)->etablissement_id != null) {
                       
                        $rules['fonction'] = 'required|max:225'; 
                        $rules['dernierDiplomeAcademique'] = 'required|max:225'; 
                        $rules['dernierDiplomeProfessionnel'] = 'required|max:225'; 
                    
                    }
                    
                    $role = Role::query()->whereIn('id', $this->get('roles'))->first();
                    if(auth()->user()->hasRole(config('constants.roles.superadmin')) && is_array($this->get('roles')) && in_array($role->name, $this->get('roles'))){
                            $rules['ia'] = 'required';
                    }
    
                    return $rules;
                }
            case 'PUT':
            case 'PATCH':
                {
                    $rules = [
                        'email' => 'email|required|max:255|unique:users,email,' . $this->get('user_id') . ',id',
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

                    if (optional(auth()->user()->personnel)->etablissement_id != null) {
                       
                        $rules['fonction'] = 'required|max:225'; 
                        $rules['dernierDiplomeAcademique'] = 'required|max:225'; 
                        $rules['dernierDiplomeProfessionnel'] = 'required|max:225'; 
                    
                    }
    
                    return $rules;
                }
            default:
                break;
        }
    }
}
