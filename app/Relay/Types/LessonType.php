<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\BibleVerseType;
use BibleExperience\Relay\Types\StepType;

use BibleExperience\Lesson as LessonModel;

class LessonType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

      	$defaultArgs = GraphQLGenerator::defaultArgs();
	$stepsConnectionType = GraphQLGenerator::connectionType($typeResolver, StepType::class);

        return parent::__construct([
            'name' => 'Lesson',
            'description' => 'A lesson of a course.',
            'fields' => [
            	'id' => Relay::globalIdField(),
          		'verse' => ['type' => $typeResolver->get(BibleVerseType::class)],
          		'title' => ['type' => Type::string()],
          		'summary' => ['type' => Type::string()],
          		'order_by' => ['type' => Type::int()],
          		'course_id' => ['type' => Type::int()],
          		'stepsCount' => ['type' => Type::int()],
          		'next' => ['type' => $typeResolver->get(LessonType::class)],
          		'previous' => ['type' => $typeResolver->get(LessonType::class)],
          		'created_at' => ['type' => Type::string()],
          		'updated_at' => ['type' => Type::string()],
	      		'steps' => [
		              'type' => $typeResolver->get($stepsConnectionType),
		              'description' => 'The steps of this lessson.',
		              'args' =>  $defaultArgs,
		              'resolve' => function($root, $args, $resolveInfo){
		                      return $this->paginatedConnection($root->steps, $args);
		                }
                      	 ]
            ],
          'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
