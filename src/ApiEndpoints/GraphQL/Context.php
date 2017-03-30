<?php
declare(strict_types = 1);

namespace ApiEndpoints\GraphQL;

final class Context
{
    private $now;

    public function __construct(\DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    public function now(): \DateTimeImmutable
    {
        return $this->now;
    }
}
