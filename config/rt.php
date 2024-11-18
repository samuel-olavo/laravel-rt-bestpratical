return [
    'base_url' => env('RT_BASE_URL'),
    'user' => env('RT_USER'),
    'password' => env('RT_PASSWORD'),
    'certificate' => env('RT_CERTIFICATE', false),  // Whether to use SSL cert
    'certificate_path' => env('RT_CERTIFICATE_PATH', ''), // Path to certificate
    'private_key_path' => env('RT_PRIVATE_KEY_PATH', ''), // Path to private key
    'certificate_chain_path' => env('RT_CERTIFICATE_CHAIN_PATH', ''), // Path to certificate chain (if any)
];

