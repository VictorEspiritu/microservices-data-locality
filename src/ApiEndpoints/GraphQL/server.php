<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Common\Domain\Model\Meetup;
use Common\Domain\Model\MeetupRepository;
use ApiEndpoints\GraphQL\Context;
use ApiEndpoints\GraphQL\Types;
use GraphQL\Schema;
use GraphQL\GraphQL;
use GraphQL\Type\Definition\Config;

Config::enableValidation();

$context = new Context(
    new \DateTimeImmutable('now')
);

$meetupRepository = new MeetupRepository();
$meetupRepository->add(new Meetup('1', new \DateTimeImmutable('-4 days')));
$meetupRepository->add(new Meetup('2', new \DateTimeImmutable('+2 days')));

$schema = new Schema([
    'query' => Types::query($meetupRepository)
]);

if (!isset($_GET['query'])) {
    throw new \RuntimeException('Provide a "query" query parameter');
}

$query = $_GET['query'];

$result = GraphQL::execute($schema, $query, null, $context);

header('Content-Type: application/json', true, 200);
echo json_encode($result);
