<?php

namespace App\Http\Controllers;

use App\Enums\EtatTransactionEnum;
use App\Enums\TypeNotification;
use App\Models\Demande;
use App\Models\Document;
use App\Models\Liste;
use App\Models\EtatWorkflow;
use App\Models\Role;
use App\Models\SuiviEtat;
use App\Models\TypeDemande;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\DocumentService;
use App\Services\NotificationService;
use App\Services\WorkflowTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class DemandeController extends Controller
{

    public function __construct(private WorkflowTools $workflowTools,
        private UserRepository $userRepository,
        // private NotificationService $notificationService,
        private DocumentService $documentService
        )
    {

    }


    public function index()
    {
        // dd($this->userRepository->getAllComiteMembers());
       
        $typeDemandes = TypeDemande::whereNull('type_demande_id')->get();
        return view('demandes.index', compact("typeDemandes"));
    }


    public function getRequestByIdEtab($etablissementId = null)
    {
        
        $typeDemandes = TypeDemande::whereNull('type_demande_id')->get();

        if(auth()->user()->hasRole(config('constants.roles.chef_etablissement')))
         {
             $typeDemandes = TypeDemande::whereNotIn('code', ['D-OUVERTURE-ETABLISSEMENT'])->get();
         }
        return view('demandes.index', compact("typeDemandes", "etablissementId"));
    }


   

    public function indexRejet( $id)
    {
        return view('parametrage.etats.motifRejet', compact("id"));

    }

    public function rejet(Request $request, $id){
        $inputs=$request->all();
        if($inputs){
            $dernierSuivi = SuiviEtat::where('id_entite', $id)
                        ->orderBy('date_entree', 'desc')
                        ->first();
                        $dernierSuivi->motif_rejet = $inputs["decision"];
                        $dernierSuivi->save();
        }
        return redirect()->route('demande.show',$id);
    }

    public function create($typeDemandeId)
    {
        $typeDemande = TypeDemande::findOrFail($typeDemandeId);
        if ($typeDemande->type_demande_id !== null) {
            return redirect()->route('demande.index');
        }
        return view('demandes.new', [
            "typeDemande"=> $typeDemande
        ]);
    }

    public function newTest($typeDemandeId){

        $typeDemande = TypeDemande::findOrFail($typeDemandeId);
        if ($typeDemande->type_demande_id !== null) {
            return redirect()->route('demande.index');
        }
        return view('demandes.new', [
            "typeDemande"=> $typeDemande
        ]);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //     ]);

    //     Demande::create([
    //         'champ1' => $request->champ1,
    //         'champ2' => $request->champ2,
    //         // Ajouter d'autres champs ici
    //     ]);

    //     return redirect()->route('demande.index')->with('success', 'Demande créée avec succès.');
    // }

    public function completer($demandeId){

        $demande = Demande::findOrFail($demandeId);
        if ($demande->etat->position != 1) {
            return redirect()->route('demande.index');
        }

        return view('demandes.completer', [
            "demande" => $demande
        ]);

    }

    // public function genererRecepisser(Demande $demande){
    //     $title = 'Recepisse_de_Depot ' . uniqid()."pdf";
    //     $pdf = Pdf::loadView('pdf.recepisse-depot', compact('demande'));

    //     // Supposons que vous ayez un modèle Document
    //     $document = new Document();
    //     $document->nom = $title;
    //     $document->documentable_type = "App\\Models\\Demande" ;
    //     $document->documentable_id = $demande->id;
    //     $document->lien_ressource = 'demandes/'.$document->nom;
    //     $document->description = "Le recepisse de dépot d'une demande";
    //     // $document->save();

    //     // $cheminDestination = "demandes/{$document->nom}";
    //     // Storage::move('pdf/'.$document->nom, $cheminDestination);

    //     $cheminDestination = storage_path("app/public/demandes/{$document->nom}");
    //     Storage::move('pdf/' . $document->nom, $cheminDestination);

    //     return $pdf->stream($document->nom);

    //     // return $pdf->download('recepisse-depot.pdf');
    // }
    public function genererRecepisser(Demande $demande){
        $document = new Document();

        $non_conforme = false;
        if(($non_conforme = $demande->etat->code != "conforme_1") && $demande->etat->code != "non_conforme_1"){
            return redirect()->route("demande.show", $demande->id);
        }

        if($non_conforme){
            $nomFichier = 'Demande_rejetee ' . uniqid() . '.pdf';
            $pdf = Pdf::loadView('pdf.demande_rejete', compact('demande'));
            $document->description = "Le document de rejet d'une demande";

        }else{
            $nomFichier = 'Demande_accepte ' . uniqid() . '.pdf';
            $pdf = Pdf::loadView('pdf.demande_accepte', compact('demande'));
            $document->description = "Le document de validation d'une demande";

        }



        $document->nom = $nomFichier;
        $document->documentable_type = "App\\Models\\Demande";
        $document->documentable_id = $demande->id;
        $document->lien_ressource = 'demandes/' . $nomFichier;

        $pdf->save("demandes/".$nomFichier, 'public');

        $document->save();

        return $pdf->stream($nomFichier);
    }


    public function show($id)
    {
        $demande = Demande::with(['etat', 'etablissement'])->findOrFail($id);
        $isAuthorized = true;
        Log::info($demande->etat);
        if($demande->etat == null || !$this->workflowTools->checkAccessRights($demande, Auth::user())){
            $isAuthorized = false;
        }
        $historiques = $demande->suivEtats()->with(['etatWorkflow', 'user'])->get();
        $documents = $demande->documents;
      /*  $recepisseDeDepot = null;

        foreach ($documents as $document) {
            if (strpos($document->nom, 'Recepisse_de_Depot') === 0 || strpos($document->nom, 'Recepisse_de_Rejet') === 0 ) {
                $recepisseDeDepot = $document;
                break;
            }
        }
        $recepisseRejetOuRecepisseDepot = $demande->etat->code == "conforme_1" ? "le récépissé de dépot" : "le récépissé de rejet";
        $recepisseTransactionSignatures = null;
        $recepisseSigned = false;
        if($recepisseDeDepot){
            $recepisseTransactionSignatures = $recepisseDeDepot->signatureTransactions;

            foreach ($recepisseTransactionSignatures as $key => $recepisseTransactionSignature) {
                if($recepisseTransactionSignature->etat == EtatTransactionEnum::SIGNE ){
                    $recepisseSigned = true;
                    break;
                }
            }
        } */

        return view('demandes.show', compact('demande',
        'isAuthorized',
        "historiques",
      //  "recepisseRejetOuRecepisseDepot",
      //  "recepisseDeDepot",
      //  "recepisseTransaction Signatures",
      //  "recepisseSigned"
     ));
    }

    public function edit($id)
    {
        $demande = Demande::findOrFail($id);

        // on a recupérer la demande, il faut vérifier que la personne connecté à le profil pour pouvoir faire la modification de la demande

        // $etat = $demande->etat;
        if($demande->etat == null || !$this->workflowTools->checkAccessRights($demande, Auth::user())){
            return redirect()->route('demande.show', $id);
        }

        return view('demandes.edit', compact('demande'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        ]);

        $demande = Demande::findOrFail($id);
        $demande->update([
            'champ1' => $request->champ1,
            'champ2' => $request->champ2,
        ]);

        return redirect()->route('demande.index')->with('success', 'Demande mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->projets()->forceDelete();
        $demande->delete();
        return redirect()->route('demande.index')->with('success', 'Demande supprimée avec succès.');
    }
}
