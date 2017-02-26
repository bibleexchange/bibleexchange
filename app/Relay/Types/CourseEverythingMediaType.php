<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\CourseEverythingSectionType;

class CourseEverythingMediaType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
        return parent::__construct([
            'name' => 'CourseEverthingMedia',
            'description' => 'media assosciated with step.',
            'fields' => [
            	'id' => Relay::globalIdField(),
          		'type' => ['type' => Type::string()]
            ],
          'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
