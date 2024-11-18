return [
    'base_url' => env('RT_BASE_URL'), // Base URL for your RT server (e.g., https://my-rt-instance.com)
    'user' => env('RT_USER'),         // Your RT username
    'password' => env('RT_PASSWORD'), // Your RT password
    'certificate_path' => env('RT_CERTIFICATE_PATH', null), // Path to the certificate file (if used)
];

