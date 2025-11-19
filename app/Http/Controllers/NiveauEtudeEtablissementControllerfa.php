<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\NiveauEtudeEtablissement;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;
use App\Repositories\UserRepository;
use App\Enums\TypeNotification as TypeNotificationEnums;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class NiveauEtudeEtablissementController extends Controller
{

    protected $notificationService;
    protected $userRepository;
    protected $logUserRepository;

     public function __construct(NotificationService $notificationService, UserRepository $userRepository, LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
        $this->logUserRepository = $logUserRepository;
    
    }

    
    public function index()
    {
        $niveauetudeetablissements = [];
        $les_metiers=[];
        if(auth()->user()->can('visualiser_mes_filieres') || auth()->user()->can('edit_mes_filieres'))
        {
            if(auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
                $idEtablissement = auth()->user()->personnel->etablissement_id ;
                $niveauetudeetablissements = NiveauEtudeEtablissement::where('etablissement_id','=', $idEtablissement)->get();
                $f0=""; $ix=0;
                foreach($niveauetudeetablissements as $niv) {
                    $nivE = NiveauEtude::find($niv->niveau_etude_id);
                    if($nivE->metier_id != $f0) {
                        $metier = Metier::find($nivE->metier_id);
                        if(!isset($les_metiers[$metier->nom]))$les_metiers[$metier->nom] = []; 
                        $les_metiers[$metier->nom][] = $niv; 
                    }
                }
            }
        }
        return view('niveauetudeetablissement.index', compact('niveauetudeetablissements', 'les_metiers'));
    }


    public function detailProgrammeFormation($id)
    {
        return view('niveauetudeetablissement.view', compact('id'));
    }


   public function create()
    {
        $niveauetudeetablissements = NiveauEtudeEtablissement::all();
        $etablissements = Etablissement::all();
        $niveauetudes = NiveauEtude::all();
        
        return view('niveauetudeetablissement.create', compact('etablissements','niveauetudes','niveauetudeetablissements'));
    }

    public function store(Request $request)
    {
        Log::info($request->all());
        $request->validate([
            'etablissement_id' => 'required|exists:etablissements,id',
            'selectedNiveau' => 'required|exists:niveau_etudes,id',
        ]);
   
        $existingEntry = NiveauEtudeEtablissement::where('etablissement_id', $request->etablissement_id)
                                              ->where('niveau_etude_id', $request->selectedNiveau)
                                              ->exists();
    
        if ($existingEntry) {
            return redirect()->route('niveauetudeetablissement.index')
            ->withMessage('Vous avez déjà choisi ce Programme de formation.');
        }
    
       $niveauEtude =  NiveauEtudeEtablissement::create([
            'etablissement_id' => $request->etablissement_id,
            'niveau_etude_id' => $request->selectedNiveau,
        ]);

        $this->logUserRepository->store(['action' => UserAction::AddNiveauEtude, 'model' => Model::NiveauEtude, 'new_object' => json_encode($niveauEtude)]);


        $etablissement = Etablissement::find($request->etablissement_id);
        $message = "Un programme de formation vient d'être rajouté. Procéder à la confirmation";
        $etablissement->update(['approved' => false]);
        $topic = "Programme de formation ajouté par". " ". $etablissement->nom;
        $this->notificationService->sendNotification($this->userRepository->getDataByRole(config('constants.roles.superadmin')), $message, TypeNotificationEnums::SYSTEME, $topic);

    
        return redirect()->route('niveauetudeetablissement.index')->withMessage('Programme ajoutée avec succès.');
    }

    
    
    public function show(NiveauEtudeEtablissement $niveauetudeetablissement)
    {
        // Récupération de niveauetude associée à cet enregistrement de NiveauEtudeEtablissement
        $niveauetude = $niveauetudeetablissement->niveau_etude;
        $startLimit = 0;
        $count=0;
    
        // Récupération des métiers associés à la filière choisie
        $metiers = Metier::whereHas('filiere', function ($query) use ($niveauetude) {
            $query->where('id', $niveauetude->id);
        })->get();
    
        // Passez les données à la vue pour l'affichage
        return view('niveauetudeetablissement.show', compact('niveauetudeetablissement', 'metiers','startLimit','count'));
    }
    
    public function edit(NiveauEtudeEtablissement $niveauetudeetablissement)
    {
        $etablissements = Etablissement::all();
        $niveau_etudes = NiveauEtude::all();

       
        return view('niveauetudeetablissement.edit', compact('etablissements','niveau_etudes','niveauetudeetablissements'));
    }

    public function update(Request $request, NiveauEtudeEtablissement $niveauetudeetablissement)
    {
        $request->validate([
            'etablissement_id' => 'required|string|max:25',
            'niveau_etude_id' => 'required|string',
        ]);

        $niveauetudeetablissement->update($request->all());

        return redirect()->route('niveauetudeetablissement.index')
                         ->withMessage('Programme de formation mis à jour avec succès.');
    }

    public function destroy(NiveauEtudeEtablissement $niveauetudeetablissement)
    {

        $this->logUserRepository->store([
            'action' => UserAction::DeleteNiveauEtude, 'model' => Model::NiveauEtude,
            'old_object' => json_encode($niveauetudeetablissement)
        ]);
        $niveauetudeetablissement->delete();

        return redirect()->route('niveauetudeetablissement.index')
                         ->withMessage('Programme de formation supprimé avec succès.');
    }


    public function validateProgramFormation($id, $decision, $idEtablissement)
    {
        $nv = null;
        $message = null;
        Etablissement::find($idEtablissement)->update(['approved' => true]);
        if($decision == 'true')
        {
            $nv = NiveauEtudeEtablissement::where('niveau_etude_id', $id)->where('etablissement_id', $idEtablissement)->first();
            $nv->update(['approved' => true]);
            $message = "Le programme de formation". $nv->niveauEtude->nom . "a été accepté";
        }
        else
        {
            $nv = NiveauEtudeEtablissement::where('niveau_etude_id', $id)->where('etablissement_id', $idEtablissement)->first();
            $nv->update(['approved' => false]);
            $message = "Le programme de formation". $nv->niveauEtude->nom . "a été rejeté";
        }        
        
        $topic = "Traitement Programme de formation";
        $this->notificationService->sendNotification($this->userRepository->getEtablissementInfoFromUser($idEtablissement), $message, TypeNotificationEnums::SYSTEME, $topic);
        return redirect()->route('program.view', $idEtablissement)->withMessage('Programme de formation mis à jour.');
    }


    public function removeProgramFormation($id, $idEtablissement)
    {
        $nv = NiveauEtudeEtablissement::where('niveau_etude_id', $id)->where('etablissement_id', $idEtablissement)->first();
        $nv->update(['isDeleted' => true]);
    
        return redirect()->route('program.view', $idEtablissement)->withMessage('Suppression du programme de formation réussie.');
    }
}