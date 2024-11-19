<?php

namespace SamuelOlavo\LaravelRTBestpratical;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RTService
{
    protected $client;
    protected $baseUrl;
    protected $apiToken;

    /**
     * Constructor to initialize the RTService.
     * Loads configuration, sets up the HTTP client, and authenticates the user.
     */
    public function __construct()
    {
        $config = config('rt');
        $this->baseUrl = rtrim($config['base_url'], '/') . '/';
        $this->apiToken = $config['api_token'];

        $this->initializeClient($config);
    }

    private function initializeClient($config)
    {
        $options = [
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'token ' . $this->apiToken,
                'Accept' => 'application/json',
            ],
        ];

        // Certificado SSL se necessário
        if (!empty($config['certificate'])) {
            $options['verify'] = $config['certificate_chain_path'] ?? $config['certificate_path'];
            $options['cert'] = [
                $config['certificate_path'],
                $config['private_key_path'],
            ];
        }

        $this->client = new Client($options);
    }

    /**
     * Get a specific ticket by ID.
     */
    public function getTicket($ticketId)
    {
        try {
            $response = $this->client->get("ticket/$ticketId");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return "Error fetching ticket: " . $e->getMessage();
        }
    }

    /**
     * Create a new ticket.
     */
    public function createTicket(array $data)
    {
        try {
            $response = $this->client->post('ticket', [
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return "Error creating ticket: " . $e->getMessage();
        }
    }
    /**
     * Update a specific ticket by ID.
     */
    public function updateTicket($ticketId, array $data)
    {
        try {
            // Sending a PUT request to update the ticket
            $response = $this->client->put("ticket/$ticketId", [
                'json' => $data
            ]);

            // Return the response decoded in JSON format
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Return an error message in case of request failure
            return "Error updating ticket: " . $e->getMessage();
        }
    }

    /**
     * add a response to the ticket
     */
    public function addResponseToTicket($ticketId, array $data)
    {
        try {
            $response = $this->client->post("ticket/$ticketId/correspond", [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return "Error posting response: " . $e->getMessage();
        }
    }
    /**
     * add a comment to the ticket
     */
    public function addCommentToTicket($ticketUrl, array $data)
    {
        try {
            $response = $this->client->post("{$ticketUrl}/correspond", [
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return "Error posting comment: " . $e->getMessage();
        }
    }
    /**
     * List tickets based on query parameters.
     */
    public function listTickets(array $queryParams = [])
    {
        try {
            $response = $this->client->get('tickets', [
                'query' => $queryParams
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return "Error listing tickets: " . $e->getMessage();
        }
    }

    /**
     * Add a comment or correspondence to a ticket.
     *
     * $type must be 'comment' or 'correspond'.
     */
    public function addCommentOrCorrespondence($ticketId, $type, array $data)
    {
        if (!in_array($type, ['comment', 'correspond'])) {
            return "Invalid type: must be 'comment' or 'correspond'.";
        }

        try {
            $response = $this->client->post("ticket/$ticketId/$type", [
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return "Error adding $type: " . $e->getMessage();
        }
    }
}

