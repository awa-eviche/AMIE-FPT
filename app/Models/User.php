<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\WorkflowTools;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;
    // private WorkflowTools $workflowTools;


    // public function __construct()
    // {
    //     $this->workflowTools = App::make('App\Services\WorkflowTools');
    // }


    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    protected $guard_name = 'web';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'prenom',
        'nom',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        "telephone",
        "canal_notification",
        "userable_type",
        "userable_id",
        'profile_photo_path',
        'role_id',
        'sexe',
        'is_deleted'

    ];

    public function suiviEtats()
    {
        return $this->hasMany(SuiviEtat::class);
    }

    // public function reunions()
    // {
    //     return $this->hasMany(Reunion::class, 'charge_suivi_id');
    // }

    public function agent()
    {
        return $this->hasOne(Agent::class, 'id', 'userable_id')->where('userable_type', 'App\Models\Agent');
    }

    public function profil()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the CategoryFile for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoryFiles(): HasMany
    {
        return $this->hasMany(CategoryFile::class);
    }

    /**
     * Get all of the fichiers for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fichiers(): HasMany
    {
        return $this->hasMany(Fichier::class);
    }


    public function getIdentiteAttribute()
    {
        return $this->prenom . ' ' . strtoupper($this->nom);
    }

    public function scopeFilterByRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('roles.name', $role);
        });
    }

    public function scopeExceptSuperadmin($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.superadmin'));
        });
    }

    public function scopeExceptIa($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.ia'));
        });
    }


    public function scopeExceptChefetablissement($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.chef_etablissement'));
        });
    }


    public function scopeExceptAutorite($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.autorite'));
        });
    }


    public function scopeExceptSurveillant($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.surveillant'));
        });
    }



    public function scopeExceptChefService($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.chef_de_service'));
        });
    }


    public function scopeExceptFormateur($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.formateur'));
        });
    }


    public function scopeExceptIntendant($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.intendant'));
        });
    }



    public function scopeExceptCheftravaux($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.chef_de_travaux'));
        });
    }

 public function scopeExceptCenseur($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.censeur'));
        });
    }

public function scopeExceptAssistante($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('roles.name', '!=', config('constants.roles.assistante'));
        });
    }
    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole(config('constants.roles.superadmin'));
    }

   public function isChefEtablissement()
{
    return $this->roles()->where('name', 'chef_etablissement')->exists();
}

    /*  public function isAdmin()
    {
        return $this->hasRole([config('constants.roles.admin'), config('constants.roles.superadmin')]);
    }*/


    public function isActive()
    {
        return $this->is_active;
    }

    public function inspecteur()
    {
    return $this->hasOne(Inspecteur::class, 'user_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getAllPersonnel(){
        if (auth()->user()->personnel != null) {
            $etablissementId = auth()->user()->personnel->etablissement_id;
            return User::query()->whereHas('personnel', function ($q) use ($etablissementId) {
                $q->where('etablissement_id', $etablissementId);
            })->count();
        }
    }
    public function countApprenant(){
        if(auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            $etablissementId =auth()->user()->personnel->etablissement_id;
            return DB::table('classes')
                            ->select('classes.etablissement_id',$etablissementId)
                            ->join('inscriptions','inscriptions.classe_id','=','classes.id')
                            ->join('apprenants', 'apprenants.id','=','inscriptions.apprenant_id')
                            ->select('apprenants.*' )
                ->distinct('apprenants.id')
                            ->count();
        }else{
            return Apprenant::query('apprenants')
            ->join('inscriptions','inscriptions.apprenant_id','=','apprenants.id')
            ->join('classes','classes.id','=','inscriptions.classe_id')
            ->join('etablissements','etablissements.id','=','classes.etablissement_id')
            ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
            ->join('metiers','metiers.id','=','niveaux.metier_id')
            ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
            ->select('apprenants.*','niveaux.nom as niveauName','classes.libelle as classeName','etablissements.sigle as etablissementSigle')
            ->count();
        }
    }
    public function personnel()
    {
        return $this->hasOne(PersonnelEtablissement::class);
    }
 public function etablissementId(): ?int
{
    // A) Compte « Établissement » (si tu en as)
    if (str_contains($this->userable_type ?? '', 'Etablissement')) {
        return $this->userable_id;
    }

    // B) Compte « Personnel » (Surveillant, Chef TR…) via personnel_etablissements
    if ($this->relationLoaded('personnel')) {
        return $this->personnel?->etablissement_id;
    }
    return $this->personnel()->value('etablissement_id');   // lazy-load
}

    public function scopeByEtablissement($query, $idEtablissement)
    {
        if ($idEtablissement) {
            return $query->whereHas('personnel', function ($q) use ($idEtablissement) {
                $q->where('etablissement_id', $idEtablissement);
            })->with('personnel.etablissement.commune');
        }

        return $query;
    }



  /*  public function countEtablissement(){
        return Etablissement::query('etablissements')
                                ->join('communes','communes.id','=','etablissements.commune_id')
                                ->join('classes','classes.etablissement_id','=','etablissements.id')
                                ->join('niveau_etudes','niveau_etudes.id','=','classes.niveau_etude_id')
                                ->join('metiers','metiers.id','=','niveau_etudes.metier_id')
                                ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
                                ->join('annee_academiques','annee_academiques.id','=','classes.annee_academique_id')
                                ->Where(function($query) {
                                    $query->where('etablissements.is_active', 1);

                                })->count();
    }*/

    public function getAllFormationByEtablissement(){
        $etablissementId =auth()->user()->personnel->etablissement_id;
        $data =  Classe::query('classes')
                    ->where('classes.etablissement_id', $etablissementId)
                    ->join('inscriptions','inscriptions.classe_id', '=', 'classes.id')
                    ->join('niveau_etudes as niveaux','niveaux.id', '=', 'classes.niveau_etude_id')
                    ->join('metiers','metiers.id','=','niveaux.metier_id')
                    ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
                    ->join('secteurs','secteurs.id','=','filieres.secteur_id')
                    ->Where(function($query) {
                        if ($this->selectedNiveau) {
                            $query->Where('niveaux.id',$this->selectedNiveau);
                        }
                        if ($this->selectedClasse) {
                            $query->Where('classes.id',$this->selectedClasse);
                        }
                        if ($this->selectedSecteur) {
                            $query->Where('secteurs.id',$this->selectedSecteur);
                        }

                    });
        return $data->distinct(['filieres.id'])->count();
    }

    public function getAllApprenantEtablissement()
    {

        $etablissementId =auth()->user()->personnel->etablissement_id;
        $apprenantsAll = Classe::query('classes')
            ->where('classes.etablissement_id',$etablissementId)
            ->join('inscriptions','inscriptions.classe_id','=','classes.id')
            ->join('apprenants', 'apprenants.id','=','inscriptions.apprenant_id')
            ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
            ->join('metiers','metiers.id','=','niveaux.metier_id')
            ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
            ->Where(function($query) {
                $query->where('apprenants.sexe','like', '%'. $this->selectedsexe.'%');
                if ($this->selectedNiveau) {
                    $query->Where('niveaux.id',$this->selectedNiveau);
                }
                if ($this->selectedClasse) {
                    $query->Where('classes.id',$this->selectedClasse);
                }
                if ($this->selectedFiliere) {
                    $query->Where('filieres.id',$this->selectedFiliere);
                }

                $query->where('apprenants.isDeleted', 0);

            });

        $apprenants = $apprenantsAll->select('apprenants.*' )->distinct(['apprenants.id'])->count();

        return $apprenants;
    }
    public function getAllFormation() {
        return Filiere::count();
    }
    
    public function getAllMetier() {
        // Démarre une requête sur le modèle Metier
        $data = Metier::query()
            ->join('filieres', 'filieres.id', '=', 'metiers.filiere_id') // Jointure avec la table filières
            ->join('secteurs', 'secteurs.id', '=', 'filieres.secteur_id') // Jointure avec la table secteurs
            ->where(function($query) {
                // Filtre par filière si sélectionnée
                if ($this->selectedFiliere) {
                    $query->where('filieres.id', $this->selectedFiliere);
                }
                // Filtre par secteur si sélectionné
                if ($this->selectedSecteur) {
                    $query->where('secteurs.id', $this->selectedSecteur);
                }
            });
    
        // Compte le nombre total de métiers distincts
        return $data->distinct()->count('metiers.id'); // Compte les métiers distincts par ID
    }
    

  public function countEtablissement() {
    return Etablissement::where('is_active', 1)->count();
}



public function countEtablissementIA()
{
    if ($this->inspecteur && $this->inspecteur->ia) {
        // On récupère les départements de cette IA
        $departements = $this->inspecteur->ia->departements->pluck('id');

        // On récupère les communes associées à ces départements
        $communes = \App\Models\Commune::whereIn('departement_id', $departements)->pluck('id');

        // On compte les établissements actifs dans ces communes
        return \App\Models\Etablissement::whereIn('commune_id', $communes)
            ->where('is_active', 1)
            ->distinct('id')
            ->count('id');
    }

    return 0;
}



public function countApprenantIA()
{
    if (!$this->inspecteur || !$this->inspecteur->ia) {
        return 0;
    }

    $ia = $this->inspecteur->ia;

    // On récupère toutes les communes liées à l’IA
    $communesIds = \App\Models\Commune::whereIn(
        'departement_id',
        $ia->departements()->pluck('departements.id')

    )->pluck('id');

    // Comptage des apprenants uniques rattachés à ces communes
    return \App\Models\Apprenant::whereIn('apprenants.commune_id', $communesIds)
        ->where('apprenants.isDeleted', 0)
        ->distinct('apprenants.id')
        ->count('apprenants.id');
}
    // public function checkAccessRights($demande){
    //     return $this->workflowTools->checkAccessRights($demande, $this);
    // }
public function classesAssignees()
    {
        return $this->belongsToMany(Classe::class, 'classe_formateur_matiere', 'formateur_id', 'classe_id')
                    ->withPivot('matiere_id')
                    ->withTimestamps();
    }
    
    public function matieresAssignees()
    {
        return $this->belongsToMany(Matiere::class, 'classe_formateur_matiere', 'formateur_id', 'matiere_id')
                    ->withPivot('classe_id')
                    ->withTimestamps();
    }
}
