<?php

use Common\DTO\Meetup;
use GuzzleHttp\Client;

require __DIR__ . '/../../vendor/autoload.php';

$httpClient = new Client();

$response = $httpClient->get('http://rest_server/');

$rawJson = $response->getBody();
$results = json_decode($rawJson);

$meetupDtos = array_map(function($meetupData) {
    return Meetup::fromData($meetupData);
}, $results);

dump($meetupDtos);
