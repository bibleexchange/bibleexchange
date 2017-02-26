<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;


use BibleExperience\Relay\Types\CourseEverythingSectionType;

class CourseEverythingType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
	$defaultArgs = GraphQLGenerator::defaultArgs();
	$sectionsConnectionType = GraphQLGenerator::connectionType($typeResolver, CourseEverythingSectionType::class);

        return parent::__construct([
            'name' => 'CourseEverthing',
            'description' => 'All course details.',
            'fields' => [
          		'title' => ['type' => Type::string()],
              'name' => ['type' => Type::string()],
              'author' => ['type' => Type::string()],
          		'description' => ['type' => Type::string()],
            	'keywords' => [
                    'type' => Type::listOf(Type::string())
                ],
            	'sections' => [
                    'type' => $typeResolver->get($sectionsConnectionType),
                    'description' => 'The sections of this course.',
                    'args' => $defaultArgs,
                    'resolve' => function($root, $args, $resolveInfo){
                        $sec = collect($root->sections);
                        return $this->paginatedConnection($sec, $args);
                    }
                ],
            ]
        ]);
    }

}
