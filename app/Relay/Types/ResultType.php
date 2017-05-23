<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\ResultType;

class ResultType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
        return parent::__construct([
            'name' => 'Result',
            'description' => 'A result.',
            'fields' => [
                'body' => ['type' => Type::string()],
                'url' => ['type' => Type::string()]
            ],
           'interfaces' => []
        ]);
    }

}
