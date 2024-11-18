<?php

namespace SamuelOlavo\LaravelRTBestpratical;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RTService
{
    protected $client;
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $config = config('rt');
        $this->baseUrl = $config['base_url'];
        $this->token = $config['api_token'];  // Your RT API token (if using API key)

        // Determine if a certificate is needed
        if (isset($config['certificate']) && $config['certificate']) {
            $this->client = new Client([
                'base_uri' => $this->baseUrl,
                'verify' => $config['certificate_path'], // Path to the certificate file
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ]
            ]);
        } else {
            $this->client = new Client([
                'base_uri' => $this->baseUrl,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ]
            ]);
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

