<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\BibleVerseType;
use BibleExperience\Relay\Types\LessonType;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\CourseEverythingType;

class CourseType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
	$defaultArgs = GraphQLGenerator::defaultArgs();
	$lessonsConnectionType = GraphQLGenerator::connectionType($typeResolver, LessonType::class);

        return parent::__construct([
            'name' => 'Course',
            'description' => 'A course.',
            'fields' => [
            	'id' => Relay::globalIdField(),
          		'verse' => ['type' => $typeResolver->get(BibleVerseType::class)],
          		'title' => ['type' => Type::string()],
          		'description' => ['type' => Type::string()],
          		'image' => ['type' => Type::string()],
          		'owner' => ['type' => $typeResolver->get(UserType::class)],
          		'lessonsCount' => ['type' => Type::int()],
          		'created_at' => ['type' => Type::string()],
              'everything_someday' => ['type' => $typeResolver->get(CourseEverythingType::class)],
              'everything' => ['type' => Type::string()],
          		'updated_at' => ['type' => Type::string()],
              	'lessons' => [
                      'type' => $typeResolver->get($lessonsConnectionType),
                      'description' => 'The lessons of this course.',
                      'args' => $defaultArgs,
                      'resolve' => function($root, $args, $resolveInfo){
                          return $this->paginatedConnection($root->getLessons($args), $args);
                      }
                  ],
            ],
          'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
