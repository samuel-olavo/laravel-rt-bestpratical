<?php

namespace SamuelOlavo\LaravelRTBestpratical;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;

class RTService
{
    protected $client;
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $cookieJar;

    public function __construct()
    {
        // Load the configuration from the .env file
        $config = config('rt');
        $this->baseUrl = $config['base_url'];
        $this->username = $config['user'];  // RT Username
        $this->password = $config['password'];  // RT Password

        // Initialize Guzzle client with or without certificates
        $this->cookieJar = new CookieJar();
        $this->initializeClient($config);

        // Authenticate and retrieve session token (if using certificates or normal auth)
        $this->authenticate();
    }

    // Method to initialize the Guzzle client based on certificate configuration
    private function initializeClient($config)
    {
        if (isset($config['certificate']) && $config['certificate']) {
            // Client with SSL certificates for authentication
            $this->client = new Client([
                'base_uri' => $this->baseUrl,
                'verify' => $config['certificate_chain_path'] ?? $config['certificate_path'], // Use certificate chain or just the certificate
                'cert' => [
                    $config['certificate_path'],  // Cert file path
                    $config['private_key_path'],  // Private Key file path
                ],
                'cookies' => $this->cookieJar,  // Store session cookies
            ]);
        } else {
            // Client without SSL certificate (standard username/password authentication)
            $this->client = new Client([
                'base_uri' => $this->baseUrl,
                'cookies' => $this->cookieJar,  // Store session cookies
            ]);
        }
    }

    // Method to authenticate and retrieve the session cookie
    private function authenticate()
    {
        try {
            // Perform POST request to authenticate using the login form
            $response = $this->client->post('/index.html', [
                'form_params' => [
                    'user' => $this->username,
                    'pass' => $this->password,
                ],
            ]);

            // Check if authentication is successful
            if ($response->getStatusCode() == 200) {
                return true; // Authentication successful
            }

            return false; // Authentication failed
        } catch (RequestException $e) {
            throw new \Exception("Error during authentication: " . $e->getMessage());
        }
    }

    // Create a ticket
    public function createTicket($subject, $description, $queue = 'General', $priority = 3)
    {
        try {
            $response = $this->client->post('/REST/1.0/ticket', [
                'json' => [
                    'Queue' => $queue,
                    'Subject' => $subject,
                    'Text' => $description,
                    'Priority' => $priority,
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // Get a ticket by ID
    public function getTicket($ticketId)
    {
        try {
            $response = $this->client->get("/REST/1.0/ticket/$ticketId");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // Search for tickets
    public function searchTickets($query = 'Status="new"')
    {
        try {
            $response = $this->client->get('/REST/1.0/ticket/search', [
                'query' => ['query' => $query]
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // Add a comment to a ticket
    public function addComment($ticketId, $comment, $isPublic = true)
    {
        try {
            $response = $this->client->post("/REST/1.0/ticket/$ticketId/comment", [
                'json' => [
                    'Text' => $comment,
                    'IsPublic' => $isPublic ? '1' : '0'
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // Update ticket (e.g., change status or priority)
    public function updateTicket($ticketId, $fields)
    {
        try {
            $response = $this->client->put("/REST/1.0/ticket/$ticketId", [
                'json' => $fields
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // Assign a ticket to a user
    public function assignTicket($ticketId, $userId)
    {
        try {
            $response = $this->client->post("/REST/1.0/ticket/$ticketId/assign", [
                'json' => ['Owner' => $userId]
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // Get a ticket's history
    public function getTicketHistory($ticketId)
    {
        try {
            $response = $this->client->get("/REST/1.0/ticket/$ticketId/history");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // Resolve a ticket
    public function resolveTicket($ticketId)
    {
        try {
            $response = $this->client->post("/REST/1.0/ticket/$ticketId/resolve");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // Delete a ticket
    public function deleteTicket($ticketId)
    {
        try {
            $response = $this->client->delete("/REST/1.0/ticket/$ticketId");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // List all queues
    public function listQueues()
    {
        try {
            $response = $this->client->get('/REST/1.0/queue');
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    // List all users
    public function listUsers()
    {
        try {
            $response = $this->client->get('/REST/1.0/user');
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }
}

