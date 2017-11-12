<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\GraphQLGenerator;
use BibleExperience\Relay\Support\PaginatedCollection;
use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\BibleVerseType;
use BibleExperience\Relay\Types\LessonType;
use BibleExperience\Relay\Types\UserType;

class CourseType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {
        return parent::__construct([
            'name' => 'Course',
            'description' => 'A course.',
            'fields' => [
            	'id' => Relay::globalIdField(),
          		'verse' => ['type' => $typeResolver->get(BibleVerseType::class)],
          		'title' => ['type' => Type::string()],
          		'description' => ['type' => Type::string()],
          		'image' => [
                'type' => Type::string(),
                'resolve' => function($root){
                  return $root->defaultImage;
                }
              ],
          		'owner' => ['type' => $typeResolver->get(UserType::class)],
          		'lessonsCount' => ['type' => Type::int()],
          		'created_at' => ['type' => Type::string()],
              
          		'updated_at' => ['type' => Type::string()],
              	'lessons' => [
                      'type' => GraphQLGenerator::resolveConnectionType($typeResolver, LessonType::class),
                      'description' => 'The lessons of this course.',
                      'args' => GraphQLGenerator::paginationArgs(),
                      'resolve' => function($root, $args, $resolveInfo){
                          return new PaginatedCollection($args, $root->lessons());
                      }
                  ],

                  'textbook' => ['type' => Type::string()],
                  'textbookSwahili' => ['type' => Type::string()]

            ],
          'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
