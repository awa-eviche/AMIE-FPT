<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Entreprise extends Model
{
    use HasFactory;

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }


    // exemple d'utilisation pour morph
    // $entreprise = Entreprise::find($entrepriseId);
    // $user = new User($userData);
    // $entreprise->users()->save($user);

    // $entreprise = Entreprise::find($entrepriseId);
    // $user = $entreprise->users()->first();


    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'entreprise_id');
    }


    protected $fillable = [
        "nom_entreprise",
        "effectif",
        "email_entreprise",
        "est_actif",
        "ninea",
        "date_creation",
        "user_id"
    ];

}
