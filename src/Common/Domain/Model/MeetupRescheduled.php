<?php
declare(strict_types=1);

namespace Common\Domain\Model;

final class MeetupRescheduled
{
    public $id;
    public $newDate;

    public function __construct(string $id, string $newDate)
    {
        $this->id = $id;
        $this->newDate = $newDate;
    }
}
