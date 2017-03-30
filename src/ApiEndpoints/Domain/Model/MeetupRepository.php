<?php
declare(strict_types = 1);

namespace ApiEndpoints\Domain\Model;

final class MeetupRepository
{
    private $meetups = [];

    public function add(Meetup $meetup)
    {
        $this->meetups[] = $meetup;
    }

    public function allMeetups(): array
    {
        return $this->meetups;
    }

    public function upcomingMeetups(\DateTimeImmutable $now): array
    {
        return array_filter(
            $this->meetups,
            function (Meetup $meetup) use ($now) {
                return $meetup->isUpcoming($now);
            }
        );
    }

    public function pastMeetups(\DateTimeImmutable $now): array
    {
        return array_filter(
            $this->meetups,
            function (Meetup $meetup) use ($now) {
                return !$meetup->isUpcoming($now);
            }
        );
    }
}
