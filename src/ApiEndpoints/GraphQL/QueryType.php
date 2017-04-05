<?php
declare(strict_types = 1);

namespace ApiEndpoints\GraphQL;

use Common\Domain\Model\Meetup;
use Common\Domain\Model\MeetupRepository;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

final class QueryType extends ObjectType
{
    /**
     * @var \Common\Domain\Model\MeetupRepository
     */
    private $meetupRepository;

    public function __construct(MeetupRepository $meetupRepository)
    {
        $this->meetupRepository = $meetupRepository;

        $config = [
            'name' => 'Query',
            'fields' => [
                'meetups' => [
                    'type' => new ListOfType(Types::meetup()),
                    'description' => 'Upcoming ',
                    'args' => [
                        'upcoming' => Type::boolean()
                    ],
                    'resolve' => [$this, 'meetups']
                ],
            ]
        ];

        parent::__construct($config);
    }

    public function meetups($rootValue, $args, Context $context, ResolveInfo $info)
    {
        if (isset($args['upcoming'])) {
            if ($args['upcoming']) {
                return $this->meetupRepository->upcomingMeetups($context->now());
            }

            return $this->meetupRepository->pastMeetups($context->now());
        }

        return $this->meetupRepository->allMeetups();
    }
}
