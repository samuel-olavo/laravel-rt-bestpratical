# Laravel RT Bestpratical Integration

This Laravel package allows you to interact with the **Request Tracker (RT)** ^5.0.0 using the REST API, including both certificate-based and token-based authentication.

## Documentation

For detailed API documentation, refer to the official Request Tracker REST API docs: [Request Tracker API Docs](https://docs.bestpractical.com/rt/5.0.0/RT/REST2.html#NAME).


## Installation

1. Add the package to your Laravel project:

    ```bash
    composer require samuel-olavo/laravel-rt-bestpratical
    ```

2. Publish the configuration file:

    ```bash
    php artisan vendor:publish --provider="SamuelOlavo\LaravelRTBestpratical\RTServiceProvider"
    ```

3. Add the following settings to your `.env` file:

    ```env
	RT_BASE_URL="https://my.rt.server/rt5/REST/2.0"
	RT_CERTIFICATE=true
	RT_USER=user
	RT_PASSWORD=password
	RT_CERTIFICATE_PATH=/path/to/your-certificate.pem
	RT_PRIVATE_KEY_PATH=/path/to/your-private-key.pem
	RT_CERTIFICATE_CHAIN_PATH=/path/to/your-cert-chain.crt
	RT_API_TOKEN="your-api-token"

    ```

## Usage


### Example 1: Create a Ticket

To create a ticket:

```php
use SamuelOlavo\LaravelRTBestpratical\RTService;

$rtService = app(RTService::class);
$ticketData = [
    'queue' => 'General',
    'subject' => 'Test ticket subject',
    'owner' => 'admin',
    'requestor' => 'user@example.com',
    'text' => 'This is the description of the ticket.',
];

$ticket = $rtService->createTicket($ticketData);

if (isset($ticket['id'])) {
    return response()->json(['message' => 'Ticket created successfully', 'ticket_id' => $ticket['id']], 201);
}

return response()->json(['error' => $ticket], 500);
```

###Example 2: Get Ticket Details

```php
$ticketDetails = $rtService->getTicket(1); // Get details for ticket ID 1
```

###Example 3: Add a Response to a Ticket

```php
$responseData = [
    'Content' => 'This is the response to the ticket. How can I assist you?',
    'ContentType' => 'text/plain',
];

$response = $rtService->addResponseToTicket(1, $responseData);

if (isset($response['message']) && $response['message'] === 'Correspondence added') {
    return response()->json(['message' => 'Response added successfully to the ticket!'], 200);
}

return response()->json(['error' => 'Error adding response to the ticket'], 500);
```
###Example 4: Update a Ticket

```php
$assignData = [
    'owner' => 'new-owner',
];

$response = $rtService->assignTicket(1, $assignData);

if (isset($response['id'])) {
    return response()->json(['message' => 'Ticket assigned successfully', 'ticket_id' => $response['id']], 200);
}

return response()->json(['error' => 'Error assigning the ticket'], 500);
```


### Available Methods

- `createTicket()`
- `getTicket()`
- `searchTickets()`
- `addComment()`
- `updateTicket()`
- `assignTicket()`
- `getTicketHistory()`
- `resolveTicket()`
- `deleteTicket()`
- `listQueues()`
- `listUsers()`

