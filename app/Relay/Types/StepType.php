<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;

use BibleExperience\Relay\Types\LessonType;
use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\NoteType;

class StepType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Step',
            'description' => 'A step of a lesson.',
            'fields' => [
          	  'id' => Relay::globalIdField(),
          		'lesson_id' => ['type' => Type::string(),'description' => ''],
          		//'lesson' => ['type' => $typeResolver->get(LessonType::class),'description' => ''],//throws exception: closure object cannot have property
          		'note_id' => ['type' => Type::string(),'description' => ''],
          		'note' => ['type' => $typeResolver->get(NoteType::class),'description' => ''],
          		'order_by' => ['type' => Type::int(),'description' => ''],
          		'next' => ['type' => $typeResolver->get(StepType::class),'description' => ''],
          		'previous' => ['type' => $typeResolver->get(StepType::class),'description' => ''],
          		'created_at' => ['type' => Type::string(),'description' => ''],
          		'updated_at' => ['type' => Type::string(),'description' => ''],
            ],
           'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
