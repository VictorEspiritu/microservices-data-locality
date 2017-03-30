<?php

use GuzzleHttp\Client;

require __DIR__ . '/../../vendor/autoload.php';

$httpClient = new Client();

$query = <<<EOD
{
    meetups(upcoming: true) {
        id
        scheduledDate
        isUpcoming
    }
}
EOD;

$response = $httpClient->get('http://api_endpoints_server/', [
    'query' => [
        'query' => $query
    ]
]);

$rawJson = $response->getBody();
$result = json_decode($rawJson);
dump($result->data);
