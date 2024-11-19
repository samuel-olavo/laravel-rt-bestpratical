<?php

/*
|----------------------------------------------------------------------
| RT Configuration
|----------------------------------------------------------------------
|
| These settings configure the connection to your RT (Request Tracker) server.
| You can specify the base URL, authentication credentials, and SSL certificates
| required to communicate with the RT API securely.
|
*/

return [
    /*
    |----------------------------------------------------------------------
    | RT Base URL
    |----------------------------------------------------------------------
    |
    | The base URL of your RT (Request Tracker) instance. This is the main URL
    | used to send requests to the RT server.
    |
    */

    'base_url' => env('RT_BASE_URL'),

    /*
    |----------------------------------------------------------------------
    | Use SSL Certificates
    |----------------------------------------------------------------------
    |
    | This setting determines whether to use SSL certificates for authentication.
    | Set this to true if you want to authenticate using certificates, or false
    | to use basic username/password authentication (if applicable).
    |
    */

    'certificate' => env('RT_CERTIFICATE', false), // Set this to true if you're using certificates

    /*
    |----------------------------------------------------------------------
    | Certificate Path
    |----------------------------------------------------------------------
    |
    | The path to your SSL certificate file, used for secure communication with
    | the RT server.
    |
    */

    'certificate_path' => env('RT_CERTIFICATE_PATH', '/path/to/your/certificate/combined.pem'),

    /*
    |----------------------------------------------------------------------
    | Private Key Path
    |----------------------------------------------------------------------
    |
    | The path to your private key file, which is used along with the certificate
    | to establish a secure connection.
    |
    */

    'private_key_path' => env('RT_PRIVATE_KEY_PATH', '/path/to/your/private/key/myDEI-API.key'),

    /*
    |----------------------------------------------------------------------
    | Certificate Chain Path
    |----------------------------------------------------------------------
    |
    | The path to your certificate chain file, which contains the chain of
    | trusted certificates necessary for secure communication.
    |
    */

    'certificate_chain_path' => env('RT_CERTIFICATE_CHAIN_PATH', '/path/to/your/certificate/chain/dei-ca-chain.crt'),


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
    |----------------------------------------------------------------------
    | RT API Token
    |----------------------------------------------------------------------
    |
    | The API token used for authentication with the RT system.
    |
    */

    'api_token' => env('RT_API_TOKEN'),
];

