<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\CourseEverythingSectionType;

class CourseEverythingStepType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
	$defaultArgs = GraphQLGenerator::defaultArgs();
	$mediaConnectionType = GraphQLGenerator::connectionType($typeResolver, CourseEverythingMediaType::class);

        return parent::__construct([
            'name' => 'CourseEverthingSection',
            'description' => 'All course details.',
            'fields' => [
            	'id' => Relay::globalIdField(),
            	'media' => [
                    'type' => $typeResolver->get($mediaConnectionType),
                    'description' => 'The sections of this course.',
                    'args' => $defaultArgs,
                    'resolve' => function($root, $args, $resolveInfo){
                    //  dd($root);
                        $media = collect($root->media);

                        return $this->paginatedConnection($media, $args);
                    }
                ],
            ],
          'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
