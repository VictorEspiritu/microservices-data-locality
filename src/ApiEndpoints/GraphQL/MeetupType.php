<?php
declare(strict_types = 1);

namespace ApiEndpoints\GraphQL;

use Common\Domain\Model\Meetup;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class MeetupType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'fields' => function () {
                return [
                    'id' => [
                        'type' => Type::id(),
                        'resolve' => function (Meetup $meetup) {
                            return $meetup->id();
                        }
                    ],
                    'scheduledDate' => [
                        'type' => Type::string(),
                        'resolve' => function (Meetup $meetup) {
                            return $meetup->scheduledDate()->format('Y-m-d H:i');
                        }
                    ],
                    'isUpcoming' => [
                        'type' => Type::boolean(),
                        'resolve' => [$this, 'isUpcoming']
                    ]
                ];
            },
        ]);
    }

    public function isUpcoming(Meetup $value, array $args, Context $context)
    {
        return $value->scheduledDate() > $context->now();
    }
}
