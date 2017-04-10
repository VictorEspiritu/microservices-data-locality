<?php

use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

require __DIR__ . '/../../vendor/autoload.php';

$stack = HandlerStack::create();
$stack->push(new CacheMiddleware(new PrivateCacheStrategy(
    new DoctrineCacheStorage(
        new FilesystemCache(__DIR__ . '/cache')
    )
)), 'private-cache');
$httpClient = new Client(['handler' => $stack]);

$response = $httpClient->get('http://rest_server_backend/upcoming-meetups');
dump($response->getHeader('Cache-Control'));
dump($response->getHeader('X-Kevinrob-Cache'));
