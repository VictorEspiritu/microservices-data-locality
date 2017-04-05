<?php
declare(strict_types=1);

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;

/** @var Client $client */
$client = require __DIR__ . '/bootstrap.php';

$channel = $client->channel();
$channel->exchangeDeclare('events', 'topic');
$channel->queueDeclare('all_events');
$channel->queueBind('all_events', 'events', '#');

$redis = new Redis();
$redis->connect('redis');

$channel->run(
    function (Message $message, Channel $channel) use ($redis) {
        echo 'Handling message: ' . $message->content . "\n";

        switch ($message->routingKey) {
            case 'meetup.meetup_scheduled':
                $eventData = json_decode($message->content);

                $projection = new \stdClass();
                $projection->scheduledDate = $eventData->provisionalDate;

                // store the initial projection
                $redis->hSet(
                    'meetups',
                    $eventData->id,
                    serialize($projection)
                );

                break;

            case 'meetup.meetup_rescheduled':
                $eventData = json_decode($message->content);

                // fetch the projection we currently have
                $projection = unserialize($redis->hGet('meetups', $eventData->id));

                // update the projection based on the new event data
                $projection->scheduledDate = $eventData->newDate;

                // store the updated projection
                $redis->hSet('meetups', $eventData->id, serialize($projection));

                break;

            default:
                error_log('Unknown message type');
        }

        dump(array_map('unserialize', $redis->hGetAll('meetups')));

        $channel->ack($message); // Acknowledge message
    },
    'all_events'
);
