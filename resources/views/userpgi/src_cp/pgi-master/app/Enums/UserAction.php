<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


abstract class UserAction extends Enum
{
    const AddUser = 'ajouter_utilisateur';
    const UpdateUser = 'mettre_a_jour_utilisateur';
    const DeleteUser = 'supprimer_utlisateur';
    const ChangeStatusUser = 'changer_status_utilisateur';

    const AddRole = 'ajouter_role';
    const UpdateRole = 'mettre_a_jour_role';
    const DeleteRole = 'supprimer_role';

    const AddAnneeAcademique = 'ajouter_annee_academique';
    const UpdateAnneeAcademique = 'mettre_a_jour_annee_academique';
    const DeleteAnneeAcademique = 'supprimer_annee_academique';

    const AddApprenant = 'ajouter_apprenant';
    const UpdateApprenant = 'mettre_a_jour_apprenant';
    const DeleteApprenant = 'supprimer_apprenant';

    const AddCategoryFichier = 'ajouter_categorie_fichier';
    const UpdateCategoryFichier = 'mettre_a_jour_categorie_fichier';
    const DeleteCategoryFichier = 'supprimer_categorie_fichier';

    const AddClasse = 'ajouter_classe';
    const UpdateClasse = 'mettre_a_jour_classe';
    const DeleteClasse = 'supprimer_classe';

    const AddCommune = 'ajouter_commune';
    const UpdateCommune = 'mettre_a_jour_commune';
    const DeleteCommune = 'supprimer_commune';

    const AddDepartement = 'ajouter_departement';
    const UpdateDepartement = 'mettre_a_jour_departement';
    const DeleteDepartement = 'supprimer_departement';

    const AddDiplome = 'ajouter_diplome';
    const UpdateDiplome = 'mettre_a_jour_diplome';
    const DeleteDiplome = 'supprimer_diplome';

    const AddDocument = 'ajouter_document';
    const UpdateDocument = 'mettre_a_jour_document';
    const DeleteDocument = 'supprimer_document';

    const AddElementCompetence = 'ajouter_element_competence';
    const UpdateElementCompetence = 'mettre_a_jour_element_competence';
    const DeleteElementCompetence = 'supprimer_element_competence';

    const AddEtablissement = 'ajouter_etablissement';
    const UpdateEtablissement = 'mettre_a_jour_etablissement';
    const DeleteEtablissement = 'supprimer_etablissement';

    const AddEvaluation = 'ajouter_evaluation';
    const UpdateEvaluation = 'mettre_a_jour_evaluation';
    const DeleteEvaluation = 'supprimer_evaluation';

    const AddFichier = 'ajouter_fichier';
    const UpdateFichier = 'mettre_a_jour_fichier';
    const DeleteFichier = 'supprimer_fichier';

    const AddFiliere = 'ajouter_filiere';
    const UpdateFiliere = 'mettre_a_jour_filiere';
    const DeleteFiliere = 'supprimer_filiere';

    const AddIA = 'ajouter_IA';
    const UpdateIA = 'mettre_a_jour_IA';
    const DeleteIA = 'supprimer_IA';

    const AddIEF = 'ajouter_IEF';
    const UpdateIEF = 'mettre_a_jour_IEF';
    const DeleteIEF = 'supprimer_IEF';

    const AddInscription = 'ajouter_inscription';
    const UpdateInscription = 'mettre_a_jour_inscription';
    const DeleteInscription = 'supprimer_inscription';

    const AddListe = 'ajouter_liste';
    const UpdateListe = 'mettre_a_jour_liste';
    const DeleteListe = 'supprimer_liste';

    const AddMatiere = 'ajouter_matiere';
    const UpdateMatiere = 'mettre_a_jour_matiere';
    const DeleteMatiere = 'supprimer_matiere';

    const AddMetier = 'ajouter_metier';
    const UpdateMetier = 'mettre_a_jour_metier';
    const DeleteMetier = 'supprimer_metier';

    const AddNiveauEtude = 'ajouter_niveau_etude';
    const UpdateNiveauEtude = 'mettre_a_jour_niveau_etude';
    const DeleteNiveauEtude = 'supprimer_niveau_etude';

    const AddRegion = 'ajouter_region';
    const UpdateRegion = 'mettre_a_jour_region';
    const DeleteRegion = 'supprimer_region';

    const AddFiliereEtablissement = 'ajouter_filiere_etablissement';
    const UpdateFiliereEtablissement = 'mettre_a_jour_filiere_etablissement';
    const DeleteFiliereEtablissement = 'supprimer_filiere_etablissement';


    const AddIndicateur = 'ajouter_indicateur';
    const UpdateIndicateur = 'mettre_a_jour_indicateur';
    const DeleteIndicateur = 'supprimer_indicateur';


    const AddSuiviIndicateur = 'ajouter_suivi_indicateur';
    const UpdateSuiviIndicateur = 'mettre_a_jour_suivi_indicateur';
    const DeleteSuiviIndicateur = 'supprimer_suivi_indicateur';


    const AddTypeIndicateur = 'ajouter_type_indicateur';
    const UpdateTypeIndicateur = 'mettre_a_jour_type_indicateur';
    const DeleteTypeIndicateur = 'supprimer_type_indicateur';



    



    public static function getDescription($value): string
    {
        switch ($value) {
            case self::AddUser:
                return 'Ajout d\'un utilisateur';
                break;
            case self::UpdateUser:
                return 'Modification d\'un utilisateur';
                break;
            case self::DeleteUser:
                return 'Suppression d\'un utilisateur';
                break;
            case self::ChangeStatusUser:
                return 'Activation \ Désactivation d\'un utilisateur';
                break;
            case self::AddRole:
                return 'Ajouter un utilisateur';
                break;
            case self::UpdateRole:
                return 'Mettre à jour un rôle';
                break;
            case self::DeleteRole:
                return 'Supprimer un rôle';
                break;
            case self::AddAnneeAcademique:
                return 'Ajout d\'une année académique';
                break;
            case self::UpdateAnneeAcademique:
                return 'Mise à jour d\'une année académique';
                break;
            case self::DeleteAnneeAcademique:
                return 'Suppression d\'une année académique';
                break;
            case self::AddApprenant:
                return 'Ajout d\'un apprenant';
                break;
            case self::UpdateApprenant:
                return 'Mise à jour d\'un apprenant';
                break;
            case self::DeleteApprenant:
                return 'Suppression d\'un apprenant';
                break;
            case self::AddCategoryFichier:
                return 'Ajout d\'une catégorie de fichier';
                break;
            case self::UpdateCategoryFichier:
                return 'Mise à jour d\'une catégorie de fichier';
                break;
            case self::DeleteCategoryFichier:
                return 'Suppression d\'une catégorie de fichier';
                break;
            case self::AddClasse:
                return 'Ajout d\'une classe';
                break;
            case self::UpdateClasse:
                return 'Mise à jour d\'une classe';
                break;
            case self::DeleteClasse:
                return 'Suppression d\'une classe';
                break;
            case self::AddCommune:
                return 'Ajout d\'une commune';
                break;
            case self::UpdateCommune:
                return 'Mise à jour d\'une commune';
                break;
            case self::DeleteCommune:
                return 'Suppression d\'une commune';
                break;
            case self::AddDepartement:
                return 'Ajout d\'un département';
                break;
            case self::UpdateDepartement:
                return 'Mise à jour d\'un département';
                break;
            case self::DeleteDepartement:
                return 'Suppression d\'un département';
                break;
            case self::AddDiplome:
                return 'Ajout d\'un diplôme';
                break;
            case self::UpdateDiplome:
                return 'Mise à jour d\'un diplôme';
                break;
            case self::DeleteDiplome:
                return 'Suppression d\'un diplôme';
                break;
            case self::AddDocument:
                return 'Ajout d\'un document';
                break;
            case self::UpdateDocument:
                return 'Mise à jour d\'un document';
                break;
            case self::DeleteDocument:
                return 'Suppression d\'un document';
                break;
            case self::AddElementCompetence:
                return 'Ajout d\'un élément de compétence';
                break;
            case self::UpdateElementCompetence:
                return 'Mise à jour d\'un élément de compétence';
                break;
            case self::DeleteElementCompetence:
                return 'Suppression d\'un élément de compétence';
                break;
            case self::AddEtablissement:
                return 'Ajout d\'un établissement';
                break;
            case self::UpdateEtablissement:
                return 'Mise à jour d\'un établissement';
                break;
            case self::DeleteEtablissement:
                return 'Suppression d\'un établissement';
                break;
            case self::AddEvaluation:
                return 'Ajout d\'une évaluation';
                break;
            case self::UpdateEvaluation:
                return 'Mise à jour d\'une évaluation';
                break;
            case self::DeleteEvaluation:
                return 'Suppression d\'une évaluation';
                break;
            case self::AddFichier:
                return 'Ajout d\'un fichier';
                break;
            case self::UpdateFichier:
                return 'Mise à jour d\'un fichier';
                break;
            case self::DeleteFichier:
                return 'Suppression d\'un fichier';
                break;
            case self::AddFiliere:
                return 'Ajout d\'une filière';
                break;
            case self::UpdateFiliere:
                return 'Mise à jour d\'une filière';
                break;
            case self::DeleteFiliere:
                return 'Suppression d\'une filière';
                break;
            case self::AddIA:
                return 'Ajout d\'une IA';
                break;
            case self::UpdateIA:
                return 'Mise à jour d\'une IA';
                break;
            case self::DeleteIA:
                return 'Suppression d\'une IA';
                break;
            case self::AddIEF:
                return 'Ajout d\'une IEF';
                break;
            case self::UpdateIEF:
                return 'Mise à jour d\'une IEF';
                break;
            case self::DeleteIEF:
                return 'Suppression d\'une IEF';
                break;
            case self::AddInscription:
                return 'Ajout d\'une inscription';
                break;
            case self::UpdateInscription:
                return 'Mise à jour d\'une inscription';
                break;
            case self::DeleteInscription:
                return 'Suppression d\'une inscription';
                break;
            case self::AddListe:
                return 'Ajout d\'une liste';
                break;
            case self::UpdateListe:
                return 'Mise à jour d\'une liste';
                break;
            case self::DeleteListe:
                return 'Suppression d\'une liste';
                break;
            case self::AddMatiere:
                return 'Ajout d\'une matière';
                break;
            case self::UpdateMatiere:
                return 'Mise à jour d\'une matière';
                break;
            case self::DeleteMatiere:
                return 'Suppression d\'une matière';
                break;
            case self::AddMetier:
                return 'Ajout d\'un métier';
                break;
            case self::UpdateMetier:
                return 'Mise à jour d\'un métier';
                break;
            case self::DeleteMetier:
                return 'Suppression d\'un métier';
                break;
            case self::AddNiveauEtude:
                return 'Ajout d\'un niveau d\'étude';
                break;
            case self::UpdateNiveauEtude:
                return 'Mise à jour d\'un niveau d\'étude';
                break;
            case self::DeleteNiveauEtude:
                return 'Suppression d\'un niveau d\'étude';
                break;
            case self::AddRegion:
                return 'Ajout d\'une région';
                break;
            case self::UpdateRegion:
                return 'Mise à jour d\'une région';
                break;
            case self::DeleteRegion:
                return 'Suppression d\'une région';
                break;
            default:
                return self::getKey($value);
        }
    }
}
