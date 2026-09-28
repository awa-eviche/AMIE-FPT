<?php
return [
    'roles' => [
        'superadmin' => 'superadmin',
        'agent' => 'agent',
        'chef_de_service' => 'chef_de_service',
        'autorite' => 'autorite',
        'chef_etablissement' => 'chef_etablissement',
        'surveillant' => 'surveillant',
        'chef_de_travaux' => 'chef_de_travaux',
        'directeur_etude' => 'directeur_etude',
        'formateur' => 'formateur',
        'intendant' => 'intendant',
        'ia' => 'ia',
        'ief' => 'ief',
        'de' => 'de',
        'censeur' => 'censeur',
        'apprenant' => 'apprenant',
    ],
    /*
     | Les notes (évaluations, compositions PPO et APC) n'ont pas d'année académique
     | propre : toutes celles présentes en base appartiennent à cette année.
     | C'est aussi l'année utilisée PAR DÉFAUT (devoirs, ressources, affectations, notes...) tant
     | qu'aucune autre n'est choisie explicitement (par exemple 2026-2027) : l'année « ouverte »
     | n'est plus utilisée comme repli.
     | Les devoirs, eux, portent leur année (annee_academique_id).
     */
    'annee_notes' => '2025-2026',
    'keys' => [
        'statut_juridique' => 'statut_juridique',
        'type' => 'type',
        'statut' => 'statut',
    ],
    'requests' => [
        'D-OUVERTURE-ETABLISSEMENT' => 'D-OUVERTURE-ETABLISSEMENT',
        'D-AUTORISATION-DIRIGER' => 'D-AUTORISATION-DIRIGER',
        'D-QUALIFICATION-FILIERE' => 'D-QUALIFICATION-FILIERE',
        'D-CHANGEMENT-DENOMINATION' => 'D-CHANGEMENT-DENOMINATION',
        'D-RECONNAISSANCE' => 'D-RECONNAISSANCE',
        'D-SUBVENTION' => 'D-SUBVENTION',
        'D-EXTENSION-FILIERE' => 'D-EXTENSION-FILIERE',
        'D-TRANSFERT-ETABLISSEMENT' => 'D-TRANSFERT-ETABLISSEMENT',
    ],
    'mail' => [
        'url' => '',
        'sujet' => '[AMIE-FPT] : ',
        'delai' => 55,
        'contact' => env('ADRESSE_MAIL_CONTACT', 'noreply@apix.sn'),
        'email' => env('MAIL_FROM_ADDRESS', 'ecommune010@gmail.com'),
    ],
    'flarum' => [
        'identification' => 'pgi',
        'granted' => 'pgi2024@',
        'url' => 'http://51.38.227.45:8083/',
    ],
       'password' => 'password',
    
];
