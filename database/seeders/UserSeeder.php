<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create(array(
            'email' => 'superadmin@pgi.sn',
            'prenom' => 'Super',
            'nom' => 'Admin',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $superadmin->assignRole(config('constants.roles.superadmin'));
        $superadmin->markEmailAsVerified();

        
        $agent = User::create(array(
            'email' => 'agent@pgi.sn',
            'prenom' => 'Agent',
            'nom' => 'Agent',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $agent->assignRole(config('constants.roles.agent'));
        $agent->markEmailAsVerified();

        // Agent
        $chef_de_service = User::create(array(
            'email' => 'chef_de_service@pgi.sn',
            'prenom' => 'Chef de Service',
            'nom' => 'Chef de Service',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $chef_de_service->assignRole(config('constants.roles.chef_de_service'));
        $chef_de_service->markEmailAsVerified();


        $autorite = User::create(array(
            'email' => 'autorite@pgi.sn',
            'prenom' => 'Autorite',
            'nom' => 'Autorite',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $autorite->assignRole(config('constants.roles.autorite'));
        $autorite->markEmailAsVerified();

        $chef_etablissement = User::create(array(
            'email' => 'chef_etablissement@pgi.sn',
            'prenom' => 'Chef Etablissement',
            'nom' => 'Chef Etablissement',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $chef_etablissement->assignRole(config('constants.roles.chef_etablissement'));
        $chef_etablissement->markEmailAsVerified();


        $surveillant = User::create(array(
            'email' => 'surveillant@pgi.sn',
            'prenom' => 'Surveillant',
            'nom' => 'Surveillant',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $surveillant->assignRole(config('constants.roles.surveillant'));
        $surveillant->markEmailAsVerified();


        $chef_de_travaux = User::create(array(
            'email' => 'chef_de_travaux@pgi.sn',
            'prenom' => 'Chef de Travaux',
            'nom' => 'Chef de Travaux',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $chef_de_travaux->assignRole(config('constants.roles.chef_de_travaux'));
        $chef_de_travaux->markEmailAsVerified();


        $formateur = User::create(array(
            'email' => 'formateur@pgi.sn',
            'prenom' => 'Formateur',
            'nom' => 'Formateur',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $formateur->assignRole(config('constants.roles.formateur'));
        $formateur->markEmailAsVerified();

        $intendant = User::create(array(
            'email' => 'intendant@pgi.sn',
            'prenom' => 'Intendant',
            'nom' => 'Intendant',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $intendant->assignRole(config('constants.roles.intendant'));
        $intendant->markEmailAsVerified();

        $ia = User::create(array(
            'email' => 'ia@pgi.sn',
            'prenom' => 'IA',
            'nom' => 'IA',
            'adresse' => 'Dakar',
            'lieu_naissance' => 'Dakar',
            'telephone' => '789876542',
            'password' => bcrypt('password')
        ));
        $ia->assignRole(config('constants.roles.ia'));
        $ia->markEmailAsVerified();

    }
    }

