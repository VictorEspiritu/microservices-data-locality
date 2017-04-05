<?php

use Common\Domain\Model\Meetup;
use Common\Domain\Model\MeetupRepository;

require_once __DIR__ . '/../../../vendor/autoload.php';

$meetupRepository = new MeetupRepository();
$meetupRepository->add(new Meetup('1', new \DateTimeImmutable('-4 days')));
$meetupRepository->add(new Meetup('2', new \DateTimeImmutable('+2 days')));

$now = new \DateTimeImmutable('now');
$upcomingMeetups = $meetupRepository->upcomingMeetups($now);

$jsonData = array_map(function (Meetup $meetup) use ($now) {
    return [
        'id' => $meetup->id(),
        'scheduledDate' => $meetup->scheduledDate()->format('Y-m-d H:i'),
        'isUpcoming' => $meetup->isUpcoming($now)
    ];
}, $upcomingMeetups);

http_response_code(200);
header('Content-Type: application/json');
header('Cache-Control: public, max-age=10');
echo json_encode($jsonData);

error_log('Fresh copy of upcoming meetups data requested');
