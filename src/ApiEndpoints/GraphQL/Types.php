<?php
declare(strict_types = 1);

namespace ApiEndpoints\GraphQL;

use ApiEndpoints\Domain\Model\MeetupRepository;

final class Types
{
    public static function query(MeetupRepository $meetupRepository): QueryType
    {
        static $node;

        return $node ?? $node = new QueryType($meetupRepository);
    }

    public static function meetup(): MeetupType
    {
        static $node;

        return $node ?? $node = new MeetupType();
    }
}
