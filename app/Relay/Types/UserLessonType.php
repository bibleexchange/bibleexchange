<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;
use BibleExperience\Relay\Support\PaginatedCollection;

use BibleExperience\Relay\Types\ActivityType;
use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\BibleVerseType;
use BibleExperience\Relay\Types\QuizType;

use BibleExperience\Lesson as LessonModel;

class UserLessonType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

  $defaultArgs = GraphQLGenerator::defaultArgs();
	
     $quizzesConnectionType = GraphQLGenerator::connectionType($typeResolver, QuizType::class);
        return parent::__construct([
            'name' => 'UserLesson',
            'description' => 'A lesson of a course.',
            'fields' => [
            	'id' => Relay::globalIdField(),
          		'verse' => ['type' => $typeResolver->get(BibleVerseType::class)],
          		'title' => ['type' => Type::string()],
          		'description' => ['type' => Type::string()],
          		'order_by' => ['type' => Type::int()],
          		'course_id' => ['type' => Type::int()],
          		'next' => ['type' => $typeResolver->get(LessonType::class)],
          		'previous' => ['type' => $typeResolver->get(LessonType::class)],
          		'created_at' => ['type' => Type::string()],
          		'updated_at' => ['type' => Type::string()],
	      		
            'activities' => [
                  'type' => $typeResolver->get(GraphQLGenerator::connectionType($typeResolver, ActivityType::class)),
                  'description' => 'The activities of this lesson.',
                  'args' =>  GraphQLGenerator::paginationArgs(),
                  'resolve' => function($root, $args, $resolveInfo){
                          return new PaginatedCollection($args, new $root->activities());
                    }
              ]


            ],
          'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
