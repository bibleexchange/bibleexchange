<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\CourseEverythingSectionType;

class CourseEverythingSectionType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
	$defaultArgs = GraphQLGenerator::defaultArgs();
	$stepsConnectionType = GraphQLGenerator::connectionType($typeResolver, CourseEverythingStepType::class);

        return parent::__construct([
            'name' => 'CourseEverthingSection',
            'description' => 'All course details.',
            'fields' => [
            	'id' => Relay::globalIdField(),
          		'title' => ['type' => Type::string()],
            	'steps' => [
                    'type' => $typeResolver->get($stepsConnectionType),
                    'description' => 'The steps of this section.',
                    'args' => $defaultArgs,
                    'resolve' => function($root, $args, $resolveInfo){

                        $steps = collect($root->steps);
                        
                        return $this->paginatedConnection($steps, $args);
                    }
                ],
            ],
          'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
