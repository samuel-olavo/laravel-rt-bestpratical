<?php

/*
|--------------------------------------------------------------------------
| RT Configuration
|--------------------------------------------------------------------------
|
| These settings configure the connection to your RT (Request Tracker) server.
| You can specify the base URL, authentication credentials, and SSL certificates
| required to communicate with the RT API securely.
|
*/

return [
    /*
    |--------------------------------------------------------------------------
    | RT Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL of your RT (Request Tracker) instance. This is the main URL
    | used to send requests to the RT server.
    |
    */

    'base_url' => env('RT_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | RT Username
    |--------------------------------------------------------------------------
    |
    | Your username for authentication with the RT system.
    |
    */

    'user' => env('RT_USER'),

    /*
    |--------------------------------------------------------------------------
    | RT Password
    |--------------------------------------------------------------------------
    |
    | The password associated with your RT username.
    |
    */

    'password' => env('RT_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Use SSL Certificates
    |--------------------------------------------------------------------------
    |
    | This setting determines whether to use SSL certificates for authentication.
    | Set this to true if you want to authenticate using certificates, or false
    | to use basic username/password authentication.
    |
    */

    'certificate' => env('RT_CERTIFICATE', false),

    /*
    |--------------------------------------------------------------------------
    | Certificate Path
    |--------------------------------------------------------------------------
    |
    | The path to your SSL certificate file. This file is used for secure 
    | communication with the RT server.
    |
    */

    'certificate_path' => env('RT_CERTIFICATE_PATH', ''),

    /*
    |--------------------------------------------------------------------------
    | Private Key Path
    |--------------------------------------------------------------------------
    |
    | The path to your private key file, which is used along with the certificate
    | to establish a secure connection.
    |
    */

    'private_key_path' => env('RT_PRIVATE_KEY_PATH', ''),

    /*
    |--------------------------------------------------------------------------
    | Certificate Chain Path
    |--------------------------------------------------------------------------
    |
    | The path to your certificate chain file, if applicable. This file contains
    | the chain of trusted certificates necessary for secure communication.
    |
    */

    'certificate_chain_path' => env('RT_CERTIFICATE_CHAIN_PATH', ''),
];

