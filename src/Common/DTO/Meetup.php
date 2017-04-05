<?php
declare(strict_types = 1);

namespace Common\DTO;

final class Meetup
{
    public $id;
    public $scheduledDate;
    public $isUpcoming;

    public static function fromData($meetupData): Meetup
    {
        $meetupDto = new Meetup();
        $meetupDto->id = $meetupData->id;
        $meetupDto->scheduledDate = $meetupData->scheduledDate;
        $meetupDto->isUpcoming = $meetupData->isUpcoming;

        return $meetupDto;
    }
}
