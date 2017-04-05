<?php
declare(strict_types = 1);

namespace Common\Domain\Model;

final class Meetup
{
    private $id;
    private $scheduledDate;

    public function __construct(string $id, \DateTimeImmutable $scheduledDate)
    {
        $this->id = $id;
        $this->scheduledDate = $scheduledDate;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function scheduledDate(): \DateTimeImmutable
    {
        return $this->scheduledDate;
    }

    public function isUpcoming(\DateTimeImmutable $now): bool
    {
        return $this->scheduledDate > $now;
    }
}
