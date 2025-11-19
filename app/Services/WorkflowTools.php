<?php

namespace App\Services;

use App\Enums\TypeNotification as EnumTypeNotification;
use App\Models\Demande;
use App\Models\EtatWorkflow;
use App\Models\PermissionEtatProfil;
use App\Models\SuiviEtat;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

class WorkflowTools {

    public function __construct(private UserRepository $userRepository, private NotificationService $notificationService, private BroadcastonIaService $broadcastonIaService) {
    }
    /**
     * initialiser le workflow
     * il faut s'assurer d'avoir fait toutes les configuration nécessaire avant d'appeler cette méthode
     * @param Demande $demande La demande concernée.
     * @param int $user_id L'ID de l'utilisateur qui effectue l'action.
     * @return bool
     */
    public function initWf(Demande $demande, $user_id) {

        $typeDemande = $demande->typeDemande;


        $workflow = $typeDemande->workflow;

        // if (!$workflow) {
        //     return "Le workflow n'est pas défini pour ce type de demande.";
        // }

        $etatInitial = $workflow->etatWorkflows()->where('position', 1)->first();

        // if (!$etatInitial) {
        //     return "L'état initial n'est pas défini pour ce workflow.";
        // }

        $suiviEtat = new SuiviEtat();
        $suiviEtat->etat_workflow_id = $etatInitial->id;
        $suiviEtat->user_id = $user_id;
        $suiviEtat->date_entree = now();
        $suiviEtat->suivi_etatable_id = $demande->id;
        $suiviEtat->suivi_etatable_type = 'App\\Models\\Demande';
        $suiviEtat->save();

        $demande->etat_id = $etatInitial->id;
        $demande->save();


        // recupérer le type de notification
        // $typeNotification = $etatInitial->typeNotifiation();
        // $profilToNotify = $typeNotification->profils();
        // appeler la méthode qui permet de notifier
        // il faudra recupérer pour chaque profil l'ensemble des id des utilisateur concerné et ensuite faire la notification
        // Pour le promoteur, c'est clair que l'on ne peut pas passer uniquement par profil. Pour cela, je pense ajouter un profil propriétaire.
        // ce qui fait que si on voit ce profil, il faudra retourner vers demande et recupérer entreprise pour lui envoyer notification

        return true;
    }

    /**
     * Passe la demande à l'état suivant dans le workflow.
     * il faut s'assurer avant d'appeler cette méthode que la demande n'est pas dans un état final
     * @param Demande $demande La demande concernée.
     * @param int $user_id L'ID de l'utilisateur qui effectue l'action.
     *
     * @return bool Retourne true s'il a pu initialiser le workflow sinon false.
     */
    public function next(Demande $demande, $user_id) {

        $etatActuel = $demande->etat;

        $etatSuivant = $etatActuel->etatSuivant;

        // if (!$etatSuivant) {
        //     return "Il n'y a pas d'état suivant dans ce workflow.";
        // }

        $dernierSuivi = SuiviEtat::where('suivi_etatable_id', $demande->id)
                                ->where('suivi_etatable_type', 'App\\Models\\Demande')
                                ->orderBy('date_entree', 'desc')
                                ->first();

        if ($dernierSuivi) {
            $dernierSuivi->date_sortie = now();
            $dernierSuivi->save();
        }

        $suiviEtat = new SuiviEtat();
        $suiviEtat->etat_workflow_id = $etatSuivant->id;
        $suiviEtat->user_id = $user_id;
        $suiviEtat->date_entree = now();
        $suiviEtat->suivi_etatable_id = $demande->id;
        $suiviEtat->suivi_etatable_type = 'App\\Models\\Demande';
        $suiviEtat->save();

        $demande->etat_id = $etatSuivant->id;
        $demande->save();


        // recupérer le type de notification
        try {
            $typeNotification = $etatSuivant->typeNotification;
            $profilToNotify = $typeNotification->roles;
            // $usersToNotify = $this->userRepository->getUsersByRoles($profilToNotify->pluck('id')->toArray());
           

            if ($profilToNotify && $profilToNotify->contains('code', "promoteur")) {
                $usersToNotify = collect([$demande->entreprise->user]);
            }else
                $usersToNotify = $this->userRepository->getUsersByRoles($profilToNotify->pluck('id')->toArray());
               

                $notifiedUsers = null;
                foreach($usersToNotify as $u)
                {
                    if($u->roles[0] != config('constants.roles.ia'))
                    {
                        $notifiedUsers[] = $u;
                    }
                }

               $this->notificationService->sendNotification($this->broadcastonIaService->findBroadcastIA($demande->etablissement->commune_id), $typeNotification->message, EnumTypeNotification::EMAIL, $typeNotification->action, ["entity"=>$demande->id, "route"=> "demande.show", "type"=>"demande"]);
               $this->notificationService->sendNotification($notifiedUsers, $typeNotification->message, EnumTypeNotification::EMAIL, $typeNotification->action, ["entity"=>$demande->id, "route"=> "demande.show", "type"=>"demande"]);
               $this->notificationService->sendNotification($this->broadcastonIaService->findBroadcastIA($demande->etablissement->commune_id), $typeNotification->message, EnumTypeNotification::SYSTEME, $typeNotification->action, ["entity"=>$demande, "route"=> "demande.show"]);
               $this->notificationService->sendNotification($notifiedUsers, $typeNotification->message, EnumTypeNotification::SYSTEME, $typeNotification->action, ["entity"=>$demande, "route"=> "demande.show"]);
            } catch (\Throwable $th) {
            return true;    
        }
        // Pour le promoteur, c'est clair que l'on ne peut pas passer uniquement par profil. Pour cela, je pense ajouter un profil propriétaire.
        // ce qui fait que si on voit ce profil, il faudra retourner vers demande et recupérer entreprise pour lui envoyer notification


        return true;
    }

    /**
     * Passe la demande à l'état rejet dans le workflow.
     * il faut s'assurer avant d'appeler cette méthode que la demande est dans un etat rejetable
     * @param Demande $demande La demande concernée.
     * @param int $user_id L'ID de l'utilisateur qui effectue l'action.
     *
     * @return bool Retourne true s'il a pu initialiser le workflow sinon false.
     */
    public function reject(Demande $demande, $user_id, $motifRejet = "") {

        $etatActuel = $demande->etat;

        $etatRejet = $etatActuel->etatRejet;

        // if (!$etatRejet) {
        //     return "Il n'y a pas d'état suivant dans ce workflow.";
        // }

        $dernierSuivi = SuiviEtat::where('suivi_etatable_id', $demande->id)
                                ->where('suivi_etatable_type', 'App\\Models\\Demande')
                                ->orderBy('date_entree', 'desc')
                                ->first();

        if ($dernierSuivi) {
            $dernierSuivi->date_sortie = now();
            $dernierSuivi->save();
        }

        $suiviEtat = new SuiviEtat();
        $suiviEtat->etat_workflow_id = $etatRejet->id;
        // $suiviEtat->etat_workflow_id = $etatRejet;
        $suiviEtat->user_id = $user_id;
        $suiviEtat->date_entree = now();
        $suiviEtat->suivi_etatable_id = $demande->id;
        $suiviEtat->motif_rejet = $motifRejet;
        $suiviEtat->suivi_etatable_type = 'App\\Models\\Demande';
        $suiviEtat->save();

        $demande->etat_id = $etatRejet->id;
        // $demande->etat_id = $etatRejet;
        $demande->save();

        try {
            $typeNotification = $etatRejet->typeNotification;
            $profilToNotify = $typeNotification->roles;
            // if($profilToNotif)
            if ($profilToNotify && $profilToNotify->contains('code', "promoteur")) {
                $usersToNotify = collect([$demande->entreprise->user]);
            }else
                $usersToNotify = $this->userRepository->getUsersByRoles($profilToNotify->pluck('id')->toArray());

            $message = "$typeNotification->message\n Motif de rejet : $motifRejet";
            $this->notificationService->sendNotification($usersToNotify, $message, EnumTypeNotification::SYSTEME, $typeNotification->action, ["entity"=>$demande, "route"=> "demande.show"]);
        } catch (\Throwable $th) {
            Log::emergency("problème avec notification de rejet");
            return true;
        }

        return true;
    }
    /**
     * Vérifie si l'utilisateur a le droit d'accéder à la demande.
     *
     * @param Demande $demande La demande concernée.
     * @param User $user L'utilisateur dont on veut vérifier les droits.
     *
     * @return bool Retourne true si l'utilisateur a le droit d'accéder à la demande, sinon false.
     */
    public function checkAccessRights(Demande $demande, User $user) {

        $profil = $user->roles[0];

        // Si l'utilisateur n'a pas de profil, il n'a pas accès à la demande
        if (!$profil) {
            return false;
        }

        // Récupérer l'état actuel de la demande
        $etatActuel = $demande->etat;

        // Vérifier si l'état actuel fait partie des états associés au profil de l'utilisateur
        $permission = PermissionEtatProfil::where('role_id', $profil->id)
                                  ->where('etat_workflow_id', $etatActuel->id)
                                  ->first();
                                  Log::info($permission);

        if ($permission) {
            // si c'est une entreprise, il faut ajouter ici la condition que la demande soit la sienne
         //   if(!$demande->entreprise->user == $user){
            if(!$demande->demandeur->email == $user->email){
                Log::info($demande->demandeur);
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Récupère tous les états auxquels l'utilisateur a accès.
     *
     * @param User $user L'utilisateur.
     * @return Collection La collection des états accessibles par l'utilisateur.
     */
    public function getAccessibleEtats(User $user) {

        $profil = $user->profil;

        // Si l'utilisateur n'a pas de profil, il n'a accès à aucun état
        if (!$profil) {
            return collect();
        }

        return $profil->etatWorkflows;
    }



}
