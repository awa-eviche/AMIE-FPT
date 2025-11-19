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
        'formateur' => 'formateur',
        'intendant' => 'intendant',
        'apprenant' => 'appprenant',
        'ia' => 'ia',
        'ief' => 'ief',
        'de' => 'de',
        'censeur' => 'censeur',
    ],
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
