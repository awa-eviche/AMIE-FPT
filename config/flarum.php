<?php

return [
    /*
     * Flarum url
     */
    'url' => env('FLARUM_URL'),

    'root' => 'localhost',

    'api_key' => env('FLARUM_API_KEY'),

    'password_token' => env('FLARUM_PASSWORD_TOKEN'),


    'lifetime_in_days' => 99999,

    'password_token' => env('FLARUM_PASSWORD_TOKEN'),






    /*
     * Flarum session configuration
     */
    'session' => [
        /*
         * Name of the Flarum session cookie
         */
        'cookie' => env('FLARUM_SESSION_COOKIE', 'flarum_session'),

        /*
         * Absolute path to the session directory of Flarum
         */
        'path' => env('FLARUM_SESSION_PATH', base_path('flarum/storage/sessions')),
    ],

    /*
     * Flarum database connection as defined in config/database.php
     */
    'db_connection' => env('FLARUM_DB_CONNECTION', 'flarum'),
];


