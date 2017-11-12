<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\GraphQLGenerator;
use BibleExperience\Relay\Support\PaginatedCollection;
use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\CourseType;
use BibleExperience\Relay\Types\LessonType;
use BibleExperience\Relay\Types\StatementType;
use BibleExperience\Relay\Types\OwnerType;

use BibleExperience\Note as NoteModel;

class TrackType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Track',
            'description' => 'A track.',
            'fields' => [
               'id' => Relay::globalIdField(),
       		   'course' => ['type' => $typeResolver->get(CourseType::class)],
       		   'user' => ['type' => $typeResolver->get(OwnerType::class)],
               'activity' => ['type' => $typeResolver->get(ActivityType::class)],
               'lesson' => ['type' => $typeResolver->get(LessonType::class)],
               'lessonStatements' => [
                    'type' => GraphQLGenerator::resolveConnectionType($typeResolver, StatementType::class),
                    'description' => 'User experience with currentLesson.',
                    'args' => GraphQLGenerator::paginationArgs(),
                    'resolve' => function($root, $args, $resolveInfo){
                          return new PaginatedCollection($args, $root->lesson->statements());

                    },
                  ]

            ],
           'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
