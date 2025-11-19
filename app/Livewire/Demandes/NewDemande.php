<?php

namespace App\Livewire\Demandes;

use App\Models\Demande;
use App\Models\Departement;
use App\Models\Document;
use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Demandeur;
use App\Models\Commune;
use App\Models\Projet;
use App\Models\Liste;
use App\Models\Region;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\WorkflowTools;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\NotificationService;
use App\Services\BroadcastonIaService;

use App\Enums\TypeNotification;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Enums\TypeNotification as TypeNotificationEnums;
use App\Livewire\Param\DemandeOuvertureEtablissement;

class NewDemande extends Component
{
 private WorkflowTools $workflowTools;
 private UserRepository $userRepository;
 private RoleRepository $roleRepository;
 private NotificationService $notificationService;
 private BroadcastonIaService $broadcastonIaService;
 use WithFileUploads;
 public $typeDemande;
 public $livewireStep = 1;
 public $filieres = [];
 public $filiereFromBD;
 public $selectionedFiliere = null;
 public $filiere_id = 0;
 public bool $isUpdating = false;
 public bool $isCharging = true;
 public $statuts;
 public $statutJuridiques;
 public $types;
 public $communes;
 public $datasets = [];
 public $entry = null;
 public $data;
 public $regions;
 public $departements;
 public $selectedRegion;
 public $selectedDepartemant;

 public $donnees = [
 "nom" => null,
 "prenom" => null,
 "email" => null,
 "adresse" => null,
 "email_etablissement" => null,
 "nom_etablissement" => null,
 "date_creation" => null,
 /* "statut_juridique" => null,*/
 "type" => null,
 "commune_id" => null,
 "statut" => null,
 "fichiers" => [],
 ];

 public $fichiers = [];
 public $fichierSecteurs = [];


 public $gotDemande;
 public $gotProjet;
 public $gotEtablissement;
 public $gotUser;


 protected $listeners = ['overtureEtablissement', 'autorisationDiriger', 'changementDenomination', 'qualificationFiliere', 'subvention', 'transfertEtablissement'];

 public function overtureEtablissement($datasets)
 {
 $this->data = $datasets;
 }

 public function autorisationDiriger($entry)
 {
 $this->data = $entry;
 }

 public function transfertEtablissement($entry)
 {
 $this->data = $entry;
 }

 public function subvention($entry)
 {
 $this->data = $entry;
 }


 public function qualificationFiliere($datasets)
 {
 $this->data = $datasets;
 }


 public function boot(
 WorkflowTools $workflowTools,
 NotificationService $notificationService,
 BroadcastonIaService $broadcastonIaService,
 UserRepository $userRepository,
 RoleRepository $roleRepository
 ) {
 $this->workflowTools = $workflowTools;
 $this->notificationService = $notificationService;
 $this->broadcastonIaService = $broadcastonIaService;
 $this->userRepository = $userRepository;
 $this->roleRepository = $roleRepository;
 $this->regions = Region::query()->get();
 $this->departements = Departement::query()->get();
 $this->communes = Commune::all();
 }

 public function mount()
 {

 if ($this->typeDemande->type_demande_id !== null) {
 return redirect()->route('demande.index');
 }




 $this->gotProjet = $this->gotDemande->projets ?? null;


 $this->gotEtablissement = $this->gotDemande->etablissement ?? null;
 $this->gotUser = $this->gotDemande->demandeur ?? null;
 if ($this->gotDemande)
 $this->isUpdating = true;

 $this->initialiserDonner();


 if (isset($this->gotDemande) && $this->gotDemande->documents != []) {
 $nombreDeFichiers = count($this->typeDemande->listes) ?? 0;
 for ($i = 0; $i < $nombreDeFichiers; $i++) {
 foreach ($this->gotDemande->documents as $key => $value) {
 if ($this->commencePar($value->nom, $this->typeDemande[$i])) {
 $this->donnees["fichiers"]["fichier_$i"][] = $value->nom;
 }
 }
 }
 }
 $nombreDeFichiers = count($this->typeDemande->listes) ?? 0;
 for ($i = 0; $i < $nombreDeFichiers; $i++) {
 $this->fichiers["fichier_$i"] = $this->donnees["fichiers"]["fichier_$i"] ?? [];
 }



 $this->isCharging = false;
 }


 public function initialiserDonner()
 {

 $this->statuts = Liste::where('libelle', 'like', config('constants.keys.statut'))->get();
 // $this->statutJuridiques = Liste::where('libelle', 'like', config('constants.keys.statut_juridique'))->get();
 $this->types = Liste::where('libelle', 'like', config('constants.keys.type'))->get();

 if (!($this->typeDemande->code == config('constants.requests.D-OUVERTURE-ETABLISSEMENT')) && (auth()->user()->hasRole(config('constants.roles.chef_etablissement')))) {
 $this->gotEtablissement = auth()->user()->personnel->etablissement;
 $this->gotUser = auth()->user();
 }
 $this->donnees["nom"] = $this->gotUser->nom ?? null;
 $this->donnees["email"] = $this->gotUser->email ?? null;
 $this->donnees["prenom"] = $this->gotUser->prenom ?? null;
 $this->donnees["adresse"] = $this->gotUser->adresse ?? null;
 $this->donnees["email_etablissement"] = $this->gotEtablissement->email ?? null;
 $this->donnees["nom_etablissement"] = $this->gotEtablissement->nom ?? null;
 // $this->donnees["statut_juridique"] = $this->gotEtablissement->statutJuridique ?? null;
 $this->donnees["statut"] = $this->gotEtablissement->statut ?? null;
 $this->donnees["type"] = $this->gotEtablissement->type ?? null;
 $this->donnees["date_creation"] = $this->gotEtablissement->dateCreation ?? null;
 $this->donnees["commune_id"] = $this->gotEtablissement->commune_id ?? null;
 }

 public function leaveStepFour(string $direction)
 {
 for ($i = 0; $i < $this->typeDemande->listes->count(); $i++) {
 for ($j = 0; $j < count($this->fichiers["fichier_$i"]); $j++) {
 $this->donnees["fichiers"]["fichier_$i"][$j] = $this->fichiers["fichier_$i"][$j]->getFileName() ?? null;
 }
 }

 if ($direction == "suivant") {
 $this->livewireStep = 5;
 } else {
 $this->livewireStep = 3;
 }
 $this->dispatch('livewireStepUpdated', $this->livewireStep);
 }

 public function something()
 {
 }

 public function onChangeType()
 {
 }

 public function onChangeStatutJuridique()
 {
 }

 public function onChangeStatut()
 {
 }

 public function onChangeRegion()
 {

 }

 public function onChangeDepartement()
 {

 }

 public function onChangeCommune()
 {
 }


 public function soumettre()
 {
 if ($this->isCharging) {
 return;
 }
 $this->isCharging = true;
 $validator = Validator::make(
 $this->donnees,
 [
 'nom' => 'required|string|max:255',
 'prenom' => 'required|string|max:255',
 // 'email' => 'required|email|unique:users,email,NULL,id,email_verified_at,NULL',
 // 'email' => 'required|email|unique:users,email,' . ($this->gotUser ? ",id,$this->gotUser->id" : ''),
 'email' => [
 'required',
 'email',
 Rule::unique('users', 'email')->ignore($this->gotUser ? $this->gotUser->id : null),
 ],
 /* 'email' => [
 'required',
 'email',
 Rule::unique('users', 'email')->ignore($this->gotUser ? $this->gotUser->id : null),
 ],*/
 'adresse' => 'required|string|max:255',
 'email_etablissement' => 'required|email',
 'date_creation' => 'required|date',
 'commune_id' => 'required',
 ],
 [
 'nom.required' => 'Le champ Nom est obligatoire.',
 'nom.string' => 'Le champ Nom doit être une chaîne de caractères.',
 'nom.max' => 'Le champ Nom ne doit pas dépasser 255 caractères.',
 'prenom.required' => 'Le champ Prénom est obligatoire.',
 'prenom.string' => 'Le champ Prénom doit être une chaîne de caractères.',
 'prenom.max' => 'Le champ Prénom ne doit pas dépasser 255 caractères.',
 'email.required' => 'Le champ Adresse e-mail est obligatoire.',
 'email.email' => 'Le champ Adresse e-mail doit être une adresse e-mail valide.',
 'email.unique' => 'Cet email existe déjà !',
 'email.unique' => 'Cet email existe déjà !',
 'adresse.required' => 'Le champ Adresse est obligatoire.',
 'adresse.string' => 'Le champ Adresse doit être une chaîne de caractères.',
 'adresse.max' => 'Le champ Adresse ne doit pas dépasser 255 caractères.',
 'email_etablissement.required' => 'Le champ Adresse e-mail de l\'entreprise est obligatoire.',
 'email_etablissement.email' => 'Le champ Adresse e-mail de l\'entreprise doit être une adresse e-mail valide.',
 'nom_etablissement.required' => 'Le champ Nom de l\'entreprise est obligatoire.',
 'nom_etablissement.string' => 'Le champ Nom de l\'entreprise doit être une chaîne de caractères.',
 'nom_etablissement.max' => 'Le champ Nom de l\'entreprise ne doit pas dépasser 255 caractères.',
 'date_creation.required' => 'Le champ Date de création de l\'entreprise est obligatoire.',
 'date_creation.date' => 'Le champ Date de création de l\'entreprise doit être une date valide.',
 'commune_id.required' => 'Le champ de la commune est requise.',
 // 'statut_juridique.required' => 'Le champ statut juridique est obligatoire.',
 // 'statut_juridique.string' => 'Le champ statut juridique doit être une chaîne de caractères.',
 'statut.required' => 'Le champ statut est obligatoire.',
 'statut.string' => 'Le champ statut doit être une chaîne de caractères.',
 'type.required' => 'Le champ type est obligatoire.',
 'type.string' => 'Le champ type doit être une chaîne de caractères.',
 // 'fichiers.*.required' => 'Le champ Fichier est obligatoire.',
 // 'fichiers.*.mimes' => 'Le champ Fichier doit être de type :values.',
 // 'fichiers.*.max' => 'Le champ Fichier ne doit pas dépasser :max kilo-octets.',
 ]
 );

 try{
 if ($validator->fails()) {

 // $this->livewireStep = 2;
 $errors = $validator->errors();
 
 if ($validator->errors()->hasAny(['nom', 'prenom', 'email', "adresse"])) {
 $this->livewireStep = 1;
 } else if ($validator->errors()->hasAny(["email_etablissement", "nom_etablissement", "statut", "type", "commune_id", "date_creation"])) {
 $this->livewireStep = 2;
 } else if ($validator->errors()->hasAny(["libelle"])) {
 $this->livewireStep = 3;
 } else if ($validator->errors()->hasAny([])) {
 $this->livewireStep = 4;
 }
 
 $this->dispatch('livewireStepUpdated', $this->livewireStep);
 $message = "Une demande vient d'être soumise. Veuillez la valider";
 $topic = "Nouvelle demande";
 $messageDemandeur = "Votre demande vient d'être soumise. Voici votre email : " . $this->donnees["email"] . " et votre mot de passe : 'passer' Je vous conseille de vous connecter et modifier ce mot de passe par défaut";
 $topicDemandeur = "Soumission de la demande";
 // $this->notificationService->sendNotification($this->userRepository->getUsersByRoleCode([config('constants.roles.superadmin'), config('constants.roles.ia')]), $message, TypeNotificationEnums::SYSTEME, $topic);
 // $this->notificationService->sendNotification([$this->userRepository->getByEmail($this->donnees["email"])], $messageDemandeur, TypeNotificationEnums::EMAIL, $topicDemandeur);
 $this->notificationService->sendNotification([['identite' => $this->donnees["nom"] . " " . $this->donnees["prenom"], 'email' => $this->donnees["email"]]], $messageDemandeur, TypeNotificationEnums::EMAIL, $topicDemandeur);
 $this->isCharging = false;
 } else {
 
 
 if ($this->gotDemande == null) {
 $this->createDemande(true);
 } else {
 $this->updateDemande();
 $this->workflowTools->next($this->gotDemande, Auth::user()->id);
 }
 $this->livewireStep = 6;
 
 $this->dispatch('livewireStepUpdated', $this->livewireStep);
 $this->isCharging = false;
 
 
 // return redirect()->route('demande.index')
 // ->with('success', 'demande mise à jour avec succès.');
 }
 $validator->validate();
 }
 catch(Exception $e)
 {
 Log::info($e);
 }
 
 }

 public function recupererObjet(int $id)
 {
 foreach ($this->secteurs as $secteur) {
 if ($secteur['id'] == $id) {
 return $secteur;
 }
 }
 return null;
 }



 public function enregistrerBrouillon()
 {
 if ($this->isCharging) {
 return;
 }
 $this->isCharging = true;
 $validator = Validator::make(
 $this->donnees,
 [
 'nom' => 'required|string|max:255',
 'prenom' => 'required|string|max:255',
 // 'email' => 'required|email|unique:users,email,NULL,id,email_verified_at,NULL',
 'email' => [
 'required',
 'email',
 Rule::unique('users', 'email')->ignore($this->gotUser ? $this->gotUser->id : null),
 ],
 'email' => 'sometimes|required|email|unique:users,email',
 'adresse' => 'required|string|max:255',
 'email_etablissement' => 'required|email',
 'nom_etablissement' => 'required|string|max:255',
 'date_creation' => 'required|date',
 // 'statut_juridique' => 'required',
 'statut' => 'required',
 'type' => 'required',
 'commune_id' => 'required',
 // 'fichiers.*' => 'required|file',
 ],
 [
 'nom.required' => 'Le champ Nom est obligatoire.',
 'nom.string' => 'Le champ Nom doit être une chaîne de caractères.',
 'nom.max' => 'Le champ Nom ne doit pas dépasser 255 caractères.',
 'prenom.required' => 'Le champ Prénom est obligatoire.',
 'prenom.string' => 'Le champ Prénom doit être une chaîne de caractères.',
 'prenom.max' => 'Le champ Prénom ne doit pas dépasser 255 caractères.',
 'email.required' => 'Le champ Adresse e-mail est obligatoire.',
 'email.email' => 'Le champ Adresse e-mail doit être une adresse e-mail valide.',
 'email.unique' => 'Cet email existe déjà !',
 'email.unique' => 'Cet email existe déjà !',
 'adresse.required' => 'Le champ Adresse est obligatoire.',
 'adresse.string' => 'Le champ Adresse doit être une chaîne de caractères.',
 'adresse.max' => 'Le champ Adresse ne doit pas dépasser 255 caractères.',
 'email_etablissement.required' => 'Le champ Adresse e-mail de l\'établissement est obligatoire.',
 'email_etablissement.email' => 'Le champ Adresse e-mail de l\'établissement doit être une adresse e-mail valide.',
 'date_creation.required' => 'Le champ Date de création de l\'établissement est obligatoire.',
 'date_creation.date' => 'Le champ Date de création de l\'établissement doit être une date valide.',
 'commune_id.required' => 'Le champ de la commune est requis',
 // 'statut_juridique.required' => 'Le champ statut juridique est obligatoire.',
 // 'statut_juridique.string' => 'Le champ statut juridique doit être une chaîne de caractères.',
 'statut.required' => 'Le champ statut est obligatoire.',
 'statut.string' => 'Le champ statut doit être une chaîne de caractères.',
 'type.required' => 'Le champ type est obligatoire.',
 'type.string' => 'Le champ type doit être une chaîne de caractères.',
 // 'fichiers.*.required' => 'Le champ Fichier est obligatoire.',
 // 'fichiers.*.mimes' => 'Le champ Fichier doit être de type :values.',
 // 'fichiers.*.max' => 'Le champ Fichier ne doit pas dépasser :max kilo-octets.',
 ]
 );
 if ($validator->fails()) {

 // $this->livewireStep = 2;
 $errors = $validator->errors();

 if ($validator->errors()->hasAny(['nom', 'prenom', 'email', 'adresse'])) {
 $this->livewireStep = 1;
 } else if ($validator->errors()->hasAny(["email_etablissement", "nom_etablissement", "commune_id", "date_creation", "statut", "type"])) {
 $this->livewireStep = 2;
 } else if ($validator->errors()->hasAny([])) {
 $this->livewireStep = 4;
 }
 $this->dispatch('livewireStepUpdated', $this->livewireStep);
 $this->isCharging = false;
 } else {

 if ($this->gotDemande == null) {
 $this->createDemande();
 } else {
 $this->updateDemande();
 }
 $this->livewireStep = 6;
 $this->dispatch('livewireStepUpdated', $this->livewireStep);
 $this->isCharging = false;



 // return redirect()->route('demande.index')
 // ->with('success', 'demande mise à jour avec succès.');
 }
 $validator->validate();
 }

 /**
 * vérifie est ce que chaine1 commence par chaine2
 * @var string chaine1 : la chaine dans laquelle, on recherche
 * @var string chaine2 : la chaine de début
 * @return bool : 1 si chaine1 commecne par chaine2 0 sinon
 */
 public function commencePar($chaine, $debut)
 {
 if (strpos($chaine, $debut) === 0) {
 }
 }

 public function createDemande(bool $soum = false)
 {
 // $this->validate();
 try {
 DB::beginTransaction();

 /* $newEtablissement = Etablissement::updateOrCreate([
 $newEtablissement = ""]);*/

 if (($this->typeDemande)->code == config('constants.requests.D-OUVERTURE-ETABLISSEMENT')){

 $newEtablissement = Etablissement::updateOrCreate([
 "email" => $this->donnees["email_etablissement"],
 "nom" => $this->donnees["nom_etablissement"],
 "dateCreation" => $this->donnees["date_creation"],
 // "statutJuridique" => $this->donnees["statut_juridique"],
 "statut" => $this->donnees["statut"],
 "type" => $this->donnees["type"],
 "commune_id" => $this->donnees["commune_id"]
 ]);

 }


 else{

 $newEtablissement = Etablissement::where('email', $this->donnees["email_etablissement"])->first();

 }

 $newDemandeur = Demandeur::updateOrCreate([
 "nom" => $this->donnees["nom"],
 "prenom" => $this->donnees["prenom"],
 "adresse" => $this->donnees["adresse"],
 "email" => $this->donnees["email"],
 ]);

 $newDemande = Demande::updateOrCreate([
 "libelle" => Str::random(12),
 "etablissement_id" => $newEtablissement->id,
 "type_demande_id" => $this->typeDemande->id,
 "demandeur_id" => $newDemandeur->id,
 "date_depot" => now(),
 "date_expiration" => now()
 ]);



 if (count($this->data) > 0) {
 if (($this->typeDemande)->code == config('constants.requests.D-OUVERTURE-ETABLISSEMENT') || ($this->typeDemande)->code == config('constants.requests.D-RECONNAISSANCE') || ($this->typeDemande)->code == config('constants.requests.D-EXTENSION-FILIERE')) {
 foreach ($this->data as $dataset) {
 $newProjet = Projet::updateOrCreate([
 "type_demande" => $this->typeDemande->libelle,
 "niveau_etude_id" => $dataset['niveau']['id'],
 "filiere_id" => $dataset['filiere']['id'],
 "demande_id" => $newDemande->id
 ]);
 }
 } else {
 $newProjet = Projet::updateOrCreate([
 "type_demande" => $this->typeDemande->libelle,
 "ancienne_adresse_etablissement" => $this->data['ancienne_adresse_etablissement'] ?? null,
 "nouvelle_adresse_etablissement" => $this->data['nouvelle_adresse_etablissement'] ?? null,
 "nouvelle_denomination_etablissement" => $this->data['nouvelle_denomination_etablissement'] ?? null,
 "ancienne_denomination_etablissement" => $this->data['ancienne_denomination_etablissement'] ?? null,
 "annee_academique_id" => $this->data['annee_academique_id'] ?? null,
 "nom" => $this->data['nom'] ?? null,
 "prenom" => $this->data['prenom'] ?? null,
 "aire" => $this->data ?? null,
 "demande_id" => $newDemande->id
 ]);
 }
 }

 $etablissement_id = $newEtablissement->id;
 // Log::info($this->roleRepository->getRolseByCode("promoteur"));
 /* $newUser = User::updateOrCreate([
 "email" => $this->donnees["email"],
 "nom" => $this->donnees["nom"],
 "prenom" => $this->donnees["prenom"],
 "date_naissance" => $this->donnees["date_naissance"],
 "lieu_naissance" => $this->donnees["lieu_naissance"],
 "adresse" => $this->donnees["adresse"],
 "telephone" => $this->donnees["telephone"],
 "password" => Hash::make("passer"),
 "userable_type" => get_class($newEtablissement),
 "userable_id" => $etablissement_id,
 "role_id" => $this->roleRepository->getRolseByCode("promoteur")->id,
 ]);*/




 // utiliser le workflow pour l'initialisation
 $this->workflowTools->initWf($newDemande, Auth::user()->id ?? 1);
 if ($soum) {
 $this->workflowTools->next($newDemande, Auth::user()->id ?? 1);
 $topicDemandeur = "Soumission de la demande portant la mention: ". " " . $newDemande->libelle . "(". $newDemande->typeDemande->libelle .")";
 $messageDemandeur = "Votre demande vient d'être soumise et est enregistrée au numéro: " . $newDemande->libelle .". Nous vous tenons informé de la situation de votre demande.";
 $ref = $this->donnees["nom"] . " " . $this->donnees["prenom"];
 $this->notificationService->sendNotification([['identite' => $ref, 'email' => $this->donnees["email"]]], $messageDemandeur, TypeNotificationEnums::EMAIL, $topicDemandeur);

 }

 for ($i = 0; $i < $this->typeDemande->listes->count(); $i++) {
 for ($j = 0; $j < count($this->fichiers["fichier_$i"]); $j++) {
 $this->donnees["fichiers"]["fichier_$i"][$j] = $this->fichiers["fichier_$i"][$j]->getFileName() ?? null;
 }
 }

 $this->uploadDocuments($this->donnees["fichiers"], $newDemande);



 DB::commit();

 $this->livewireStep = 1;
 return;
 } catch (\Exception $th) {
 Log::info("Erreur survenue======>");
 Log::info($th);
 }
 }

 public function updateDemande()
 {

 // $this->validate();


 DB::beginTransaction();

 $this->gotDemande->update([
 "date_depot" => now(),
 "date_expiration" => now(),
 ]);

 $this->gotEtablissement->update([
 "email" => $this->donnees["email_etablissement"],
 "nom" => $this->donnees["nom_etablissement"],
 "dateCreation" => $this->donnees["date_creation"],
 // "statutJuridique" => $this->donnees["statut_juridique"],
 "statut" => $this->donnees["statut"],
 "type" => $this->donnees["type"],

 ]);


 if (count($this->data) > 0) {
 if (($this->typeDemande)->code == config('constants.requests.D-OUVERTURE-ETABLISSEMENT') || ($this->typeDemande)->code == config('constants.requests.D-RECONNAISSANCE') || ($this->typeDemande)->code == config('constants.requests.D-EXTENSION-FILIERE')) {
 foreach ($this->data as $dataset) {
 $newProjet = Projet::updateOrCreate([
 "type_demande" => $this->typeDemande->libelle,
 "niveau_etude_id" => $dataset['niveau']['id'],
 "filiere_id" => $dataset['filiere']['id'],
 "demande_id" => $this->gotDemande->id
 ]);
 }
 } else {

 $newProjet = Projet::updateOrCreate([
 "type_demande" => $this->typeDemande->libelle,
 "ancienne_adresse_etablissement" => $this->data['ancienne_adresse_etablissement'] ?? null,
 "nouvelle_adresse_etablissement" => $this->data['nouvelle_adresse_etablissement'] ?? null,
 "nouvelle_denomination_etablissement" => $this->data['nouvelle_denomination_etablissement'] ?? null,
 "ancienne_denomination_etablissement" => $this->data['ancienne_denomination_etablissement'] ?? null,
 "annee_academique_id" => $this->data['annee_academique_id'] ?? null,
 "nom" => $this->data['nom'] ?? null,
 "prenom" => $this->data['prenom'] ?? null,
 "aire" => $this->data ?? null,
 "demande_id" => $this->gotDemande->id
 ]);
 }
 }

 /* $this->gotProjet->update([
 "type_agrement"=> $this->typeDemande->libelle,
 "secteur_id"=> $this->secteur_id,
 ]);

 if(count($this->datasets) > 0)
 {
 foreach ($this->datasets as $dataset) {
 $newProjet = Projet::updateOrCreate([
 "type_demande"=> $this->typeDemande->libelle,
 "niveau_etude_id" => $this->dataset->niveau->id,
 "filiere_id" => $this->dataset->filiere->id,
 "demande_id" => $newDemande->id
 ]);
 }*/

 $this->gotUser->update([
 "email" => $this->donnees["email"],
 "nom" => $this->donnees["nom"],
 "prenom" => $this->donnees["prenom"],
 "adresse" => $this->donnees["adresse"],

 ]);

 $this->uploadDocuments($this->donnees["fichiers"], $this->gotDemande, true);



 DB::commit();

 return;
 }


 public function uploadDocuments($fichiers, $demande)
 {

 $documents = null;
 // si on fait un update, il faut enlever les anciens documents qui ne sont pas dans le nouveau tableau

 // upload les documents du secteur
 if (!empty($fichiers)) {
 $mdNombre = 0;
 foreach ($fichiers as $index => $fichierTable) {

 foreach ($fichierTable as $key => $fichier) {
 $document = new Document();

 $cheminTemporaire = storage_path("app/livewire-tmp/{$fichier}");

 if (file_exists($cheminTemporaire)) {
 $listeDocument = $this->typeDemande->listes;
 $libelle = $listeDocument[$mdNombre]->libelle;
 $nomFichierUnique = $libelle . '_' . "$key" . "_" . uniqid() . '.' . pathinfo($fichier, PATHINFO_EXTENSION);

 $cheminFinal = storage_path("app/public/demandes/{$nomFichierUnique}");

 // Déplacer le fichier vers le stockage final
 rename($cheminTemporaire, $cheminFinal);

 // Enregistrer le document dans la base de données
 $document->nom = $nomFichierUnique;
 $document->lien_ressource = "demandes/{$nomFichierUnique}";
 $document->description = $listeDocument[$mdNombre]->description;
 $document->documentable_id = $demande->id;
 $document->documentable_type = "App\\Models\\Demande";
 $document->save();
 }
 }
 $mdNombre++;
 }
 }

 if (!empty($this->fichierSecteurs)) {
 $mdNombre = 0;
 foreach ($this->fichierSecteurs as $index => $fichierTable) {

 foreach ($fichierTable as $key => $fichier) {
 $document = new Document();

 $cheminTemporaire = storage_path("app/livewire-tmp/{$fichier->getFileName()}");

 if (file_exists($cheminTemporaire)) {
 $listeDocument = $this->selectionedSecteur->listes;
 $libelle = $listeDocument[$mdNombre]->libelle;
 $nomFichierUnique = $libelle . '_' . "$key" . "_" . uniqid() . '.' . pathinfo($fichier->getFileName(), PATHINFO_EXTENSION);

 $cheminFinal = storage_path("app/public/demandes/{$nomFichierUnique}");

 // Déplacer le fichier vers le stockage final
 rename($cheminTemporaire, $cheminFinal);

 // Enregistrer le document dans la base de données
 $document->nom = $nomFichierUnique;
 $document->lien_ressource = "demandes/{$nomFichierUnique}";
 $document->description = $listeDocument[$mdNombre]->description;
 $document->documentable_id = $demande->id;
 $document->documentable_type = "App\\Models\\Demande";
 $document->save();
 }
 }
 $mdNombre++;
 }
 }
 }





 public function render()
 {
 if ($this->selectedRegion){
 $this->departements = Departement::query()->where("region_id", $this->selectedRegion)->get();
 }
 if ($this->selectedDepartemant){
 $this->communes = Commune::query()->where("departement_id", $this->selectedDepartemant)->get();
 }
 return view('livewire.demandes.new-demande');
 }
}
