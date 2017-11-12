<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\GraphQLGenerator;
use BibleExperience\Relay\Support\PaginatedCollection;

use BibleExperience\Relay\Types\LessonType;
use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\Relay\Types\StatementType;

class ActivityType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {
        return parent::__construct([
            'name' => 'Activity',
            'description' => 'An activity of a lesson.',
            'fields' => [
          	  'id' => Relay::globalIdField(),
          		'lesson' => ['type' => $typeResolver->get(LessonType::class)],
          		'config' => ['type' => Type::string()],
          		'body' => ['type' => Type::string()],
          		'order_by' => ['type' => Type::int()],
          		'created_at' => ['type' => Type::string()],
          		'updated_at' => ['type' => Type::string()]
            ],
           'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
