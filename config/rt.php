<?php

return [
    'base_url' => env('RT_BASE_URL', 'https://your-rt-server.com'), // The base URL for your RT instance
    'api_token' => env('RT_API_TOKEN', 'your-api-token'), // RT API token for authentication

    // If certificate is needed
    'certificate' => env('RT_CERTIFICATE', false), // true or false, if certificate is used
    'certificate_path' => env('RT_CERTIFICATE_PATH', '/path/to/your/certificate.pem'), // Path to certificate
];

