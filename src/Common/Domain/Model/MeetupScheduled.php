<?php
declare(strict_types=1);

namespace Common\Domain\Model;

final class MeetupScheduled
{
    public $id;
    public $provisionalDate;

    public function __construct(string $id, string $provisionalDate)
    {
        $this->id = $id;
        $this->provisionalDate = $provisionalDate;
    }
}
