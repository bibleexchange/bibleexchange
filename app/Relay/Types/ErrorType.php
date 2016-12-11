<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;

class ErrorType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {
        return parent::__construct([
            'name' => 'Error',
            'description' => 'An error.',
            'fields' => [
            		'message' => ['type' => Type::string()],
            		'code' => ['type' => Type::int()],
            ],
           'interfaces' => []
        ]);
    }

}
