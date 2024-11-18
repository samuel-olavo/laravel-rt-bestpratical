<?php

namespace SamuelOlavo\LaravelRTBestpratical;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RTService
{
    protected $client;
    protected $sessionToken;
    protected $cookieJar;
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        // Configuration for URL and credentials
        $this->baseUrl = config('rt.base_url'); // Base URL of your RT
        $this->username = config('rt.user'); // Login username
        $this->password = config('rt.password'); // Login password

        // Temporary file to save the session cookie
        $this->cookieJar = tempnam(sys_get_temp_dir(), 'rt_session');

        // Initialize Guzzle client
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'cookies' => $this->cookieJar, // Use the cookieJar to store the session cookie
        ]);
    }

    // Method to authenticate and retrieve the session cookie
    public function authenticate()
    {
        try {
            $response = $this->client->post('/index.html', [
                'form_params' => [
                    'user' => $this->username,
                    'pass' => $this->password,
                ]
            ]);

            // Check if the authentication was successful
            if ($response->getStatusCode() == 200) {
                $this->sessionToken = $this->extractSessionToken($response);
                return true; // Authentication successful
            }

            return false; // Authentication failed

        } catch (RequestException $e) {
            throw new \Exception("Error during authentication: " . $e->getMessage());
        }
    }

    // Method to extract the session token from the response
    protected function extractSessionToken($response)
    {
        // Extract the session cookie from the response headers
        return $response->getHeader('Set-Cookie')[0];
    }

    // Method to make a request using the session cookie
    public function requestWithSession($url, $data = [], $method = 'GET')
    {
        try {
            $options = [
                'cookies' => $this->cookieJar, // Pass the session cookie
            ];

            if ($method == 'POST') {
                $options['form_params'] = $data;
            }

            $response = $this->client->request($method, $this->baseUrl . $url, $options);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            throw new \Exception("Error during request: " . $e->getMessage());
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

    // Update a ticket (e.g., change status or priority)
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

