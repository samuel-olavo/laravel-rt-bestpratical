# Laravel RT Bestpratical Integration

This Laravel package allows you to interact with the **Request Tracker (RT)** using the REST API, including both certificate-based and token-based authentication.

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
    RT_BASE_URL=https://your-rt-server.com
    RT_API_TOKEN=your-api-token
    RT_CERTIFICATE=false  # Set to false if you are not using a certificate
    RT_CERTIFICATE_PATH=/path/to/your/certificate.pem
    ```

## Usage

To create a ticket:

```php
use SamuelOlavo\LaravelRTBestpratical\RTService;
```

$rtService = app(RTService::class);
$ticket = $rtService->createTicket('Subject of ticket', 'Description of the ticket');

To get ticket details:

```php
$ticketDetails = $rtService->getTicket(1); // Get details for ticket ID 1

```
## Available Methods

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

