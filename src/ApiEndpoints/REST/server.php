<?php

use Common\Domain\Model\Meetup;
use Common\Domain\Model\MeetupRepository;
use function Common\Serialization\json_encode;

require_once __DIR__ . '/../../../vendor/autoload.php';

$meetupRepository = new MeetupRepository();
$meetupRepository->add(new Meetup('1', new \DateTimeImmutable('20:00 -4 days')));
$meetupRepository->add(new Meetup('2', new \DateTimeImmutable('19:00 +2 days')));

$now = new \DateTimeImmutable('now');

// Get all upcoming meetups based on the current date/time:
$upcomingMeetups = $meetupRepository->upcomingMeetups($now);

// Convert domain objects to DTOs:
$jsonData = array_map(function (Meetup $meetup) use ($now) {
    $meetupDto = new \stdClass();
    $meetupDto->id = $meetup->id();
    $meetupDto->scheduledDate = $meetup->scheduledDate()->format('Y-m-d H:i');
    $meetupDto->isUpcoming = $meetup->isUpcoming($now);

    return $meetupDto;
}, $upcomingMeetups);

// Send the HTTP response:
http_response_code(200);
header('Content-Type: application/json');
header('Cache-Control: public, max-age=10, s-max-age=10');
echo json_encode($jsonData);

error_log('Fresh copy of upcoming meetups data requested');
