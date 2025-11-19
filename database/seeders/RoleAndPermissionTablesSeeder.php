<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RoleAndPermissionTablesSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        //Roles
        Role::create(['code' => config('constants.roles.superadmin'),'name' => config('constants.roles.superadmin'), 'description' => 'Super Administrateur', 'guard_name' => 'web', 'is_deletable' => false]);
        $agent = Role::create(['code' => config('constants.roles.agent'), 'name' => config('constants.roles.agent'), 'description' => 'Agent', 'guard_name' => 'web', 'is_deletable' => false]);
        $chef_de_service = Role::create(['code' => config('constants.roles.chef_de_service'), 'name' => config('constants.roles.chef_de_service'), 'description' => 'Chef de service', 'guard_name' => 'web', 'is_deletable' => false]);
        $autorite = Role::create(['code' => config('constants.roles.autorite'), 'name' => config('constants.roles.autorite'), 'description' => 'Autorité', 'guard_name' => 'web', 'is_deletable' => false]);
        $chef_etablissement = Role::create(['code' => config('constants.roles.chef_etablissement'), 'name' => config('constants.roles.chef_etablissement'), 'description' => 'Chef Etablissement', 'guard_name' => 'web', 'is_deletable' => false]);
        $chef_de_travaux = Role::create(['code' => config('constants.roles.chef_de_travaux'), 'name' => config('constants.roles.chef_de_travaux'), 'description' => 'Chef de Travaux', 'guard_name' => 'web', 'is_deletable' => false]);
        $surveillant = Role::create(['code' => config('constants.roles.surveillant'), 'name' => config('constants.roles.surveillant'), 'description' => 'Surveillant', 'guard_name' => 'web', 'is_deletable' => false]);
        $formateur = Role::create(['code' => config('constants.roles.formateur'), 'name' => config('constants.roles.formateur'), 'description' => 'Formateur', 'guard_name' => 'web', 'is_deletable' => false]);
        $intendant = Role::create(['code' => config('constants.roles.intendant'), 'name' => config('constants.roles.intendant'), 'description' => 'Intendant', 'guard_name' => 'web', 'is_deletable' => false]);
        $ia = Role::create(['code' => config('constants.roles.ia'), 'name' => config('constants.roles.ia'), 'description' => 'IA', 'guard_name' => 'web', 'is_deletable' => false]);
        $ief = Role::create(['code' => config('constants.roles.ief'), 'name' => config('constants.roles.ief'), 'description' => 'IEF', 'guard_name' => 'web', 'is_deletable' => false]);
        $de = Role::create(['code' => config('constants.roles.de'), 'name' => config('constants.roles.de'), 'description' => 'DE', 'guard_name' => 'web', 'is_deletable' => false]);
        $censeur = Role::create(['code' => config('constants.roles.censeur'), 'name' => config('constants.roles.censeur'), 'description' => 'Censeur', 'guard_name' => 'web', 'is_deletable' => false]);

        //Permissions
        $perm = Permission::create(['name' => 'edit_etablissement', 'description' => 'Editer l\'Etablissement', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service]);
        $perm = Permission::create(['name' => 'visualiser_etablissement', 'description' => 'Visualiser l\'Etablissement', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service, $autorite, $ia, $ief]);
        $perm = Permission::create(['name' => 'supp_etablissement', 'description' => 'Supprimer l\'Etablissement', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_service]);
        $perm = Permission::create(['name' => 'edit_filiere', 'description' => 'Editer la Filière', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service]);
        $perm = Permission::create(['name' => 'visualiser_filiere', 'description' => 'Visualiser la Filière', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service, $autorite]);
        $perm = Permission::create(['name' => 'edit_mes_filieres', 'description' => 'Editer mes Filières', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_etablissement]);
        $perm = Permission::create(['name' => 'visualiser_mes_filieres', 'description' => 'Visualiser mes Filières', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_etablissement, $formateur, $surveillant, $chef_de_travaux]);
        $perm = Permission::create(['name' => 'supp_filiere', 'description' => 'Supprimer la Filière', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_service]);
        $perm = Permission::create(['name' => 'edit_metier', 'description' => 'Editer le Métier', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent,$chef_de_service ]);
        $perm = Permission::create(['name' => 'visualiser_metier', 'description' => 'Visualiser le Métier', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent,$chef_de_service]);
        $perm = Permission::create(['name' => 'supp_metier', 'description' => 'Supprimer le Métier', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_service]);
        $perm = Permission::create(['name' => 'edit_niveau', 'description' => 'Editer le Niveau', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service]);
        $perm = Permission::create(['name' => 'visualiser_niveau', 'description' => 'Visualiser le Niveau', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service, $autorite]);
        $perm = Permission::create(['name' => 'supp_niveau', 'description' => 'Supprimer le Niveau', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_service]);
        $perm = Permission::create(['name' => 'edit_domaine', 'description' => 'Editer le Domaine', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent,$chef_de_service]);
        $perm = Permission::create(['name' => 'visualiser_domaine', 'description' => 'Visualiser le Domaine', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service, $autorite]);
        $perm = Permission::create(['name' => 'supp_domaine', 'description' => 'Supprimer le Domaine', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_service]);
        $perm = Permission::create(['name' => 'creer_document', 'description' => 'Créer un Document', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent]); 
        $perm = Permission::create(['name' => 'edit_document', 'description' => 'Editer un Document', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_service]); 
        $perm = Permission::create(['name' => 'visualiser_document', 'description' => 'Visualiser un Document', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service]);
        $perm = Permission::create(['name' => 'supp_document', 'description' => 'Supprimer un Document', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_service]);
        $perm = Permission::create(['name' => 'creer_forum', 'description' => 'Créer un Forum', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service, $autorite]);
        $perm = Permission::create(['name' => 'participer_forum', 'description' => 'Participer à un Forum', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service, $autorite]);
        $perm = Permission::create(['name' => 'visualiser_indicateur', 'description' => 'Visualiser les indicateurs', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent, $chef_de_service, $autorite]);
        $perm = Permission::create(['name' => 'visualiser_demande', 'description' => 'Visualiser une demande', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$agent]);
        $perm = Permission::create(['name' => 'valider_demande', 'description' => 'Valider une demande', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_service, $autorite]);
        $perm = Permission::create(['name' => 'edit_personnel', 'description' => 'Editer un personnel', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_etablissement, $surveillant]);
        $perm = Permission::create(['name' => 'supp_personnel', 'description' => 'Supprimer un personnel', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_etablissement, $surveillant]);
        $perm = Permission::create(['name' => 'visualiser_personnel', 'description' => 'Visualiser un personnel', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_etablissement, $surveillant]);
        $perm = Permission::create(['name' => 'supp_classe_matiere', 'description' => 'Supprimer la matière d\'une classe', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_etablissement]);
        $perm = Permission::create(['name' => 'visualiser_classe_matiere', 'description' => 'Visualiser la matière d\'une classe', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_travaux, $chef_etablissement, $formateur]);
        $perm = Permission::create(['name' => 'edit_classe_matiere', 'description' => 'Editer la matière d\'une classe', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_de_travaux, $chef_etablissement, $formateur]);
        $perm = Permission::create(['name' => 'edit_apprenant', 'description' => 'Editer l\'apprenant', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$intendant, $chef_etablissement]);
        $perm = Permission::create(['name' => 'visualiser_apprenant', 'description' => 'Visualiser l\'apprenant', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$intendant, $chef_etablissement, $chef_de_travaux, $formateur]);
        $perm = Permission::create(['name' => 'visualiser_etablissement_info', 'description' => 'Visualiser l\'apprenant', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$intendant, $chef_etablissement, $chef_de_travaux, $formateur]);
        $perm = Permission::create(['name' => 'modifier_mon_etablissement', 'description' => 'Modifier mon établissement', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$intendant, $chef_etablissement, $chef_de_travaux, $formateur]);
        $perm = Permission::create(['name' => 'gerer_parametrage', 'description' => 'Gérer le paramétrage', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm = Permission::create(['name' => 'gerer_utilisateur', 'description' => 'Gérer les utilisateurs', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm = Permission::create(['name' => 'gerer_role', 'description' => 'Gérer les rôles', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm = Permission::create(['name' => 'voir_historique', 'description' => 'Voir l\'historique des utilisateurs', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm = Permission::create(['name' => 'gerer_administration', 'description' => 'Gérer administration', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm = Permission::create(['name' => 'edit_inscription', 'description' => 'Editer mes Inscriptions', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm = Permission::create(['name' => 'visualiser_evaluation', 'description' => 'Visualiser l/evaluation', 'guard_name' => 'web', 'is_deletable' => false]);
        $perm->syncRoles([$chef_etablissement, $formateur, $surveillant, $chef_de_travaux]);
        $perm = Permission::create(['name' => 'gerer_actualite_et_faq', 'description' => 'Gérer l\'actualité et la foire aux questions', 'guard_name' => 'web', 'is_deletable' => false]);


    } 
}
