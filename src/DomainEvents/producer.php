<?php
declare(strict_types=1);

use Bunny\Client;
use Common\Domain\Model\MeetupRescheduled;
use Common\Domain\Model\MeetupScheduled;
use function Common\Serialization\json_encode;

/** @var Client $client */
$client = require __DIR__ . '/bootstrap.php';

$channel = $client->channel();
$channel->exchangeDeclare('events', 'topic');

$meetupId = 'ad6fb815-c26c-41c2-a5bd-b4bb055d6447';
$meetupId = (string)\Ramsey\Uuid\Uuid::uuid4();

// domain event, normally created by an entity:
$meetupScheduledEvent = new MeetupScheduled(
    $meetupId,
    '2017-06-09 20:00'
);

// another domain event, created by an entity:
$newDate = '2017-06-20 19:00';
$meetupRescheduledEvent = new MeetupRescheduled(
    $meetupId,
    $newDate
);

$channel->publish(
    json_encode($meetupScheduledEvent),
    ['Content-Type' => 'application/json'],
    'events',
    'meetup.meetup_scheduled'
);

$channel->publish(
    json_encode($meetupRescheduledEvent),
    ['Content-Type' => 'application/json'],
    'events',
    'meetup.meetup_rescheduled'
);
