<?php

use Common\DTO\Meetup;
use GuzzleHttp\Client;

require __DIR__ . '/../../../vendor/autoload.php';

$httpClient = new Client();

$query = <<<EOD
{
    meetups(upcoming: true) {
        id
        newDate
        isUpcoming
    }
}
EOD;

$response = $httpClient->get('http://graphql_server/', [
    'query' => [
        'query' => $query
    ]
]);

$rawJson = $response->getBody();
$results = json_decode($rawJson);

$meetupDtos = array_map(function($meetupData) {
    return Meetup::fromData($meetupData);
}, $results->data->meetups);

dump($meetupDtos);
