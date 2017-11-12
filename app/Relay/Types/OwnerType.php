<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;

class OwnerType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Owner',
            'description' => '',
            'fields' => [
          	        'id' => Relay::globalIdField(),
                    'name' => [
                        'type' => Type::string(),
                        'description' => '',
                    ],
                    'email' => [
                        'type' => Type::string(),
                        'description' => '',
                    ],
                    'nickname' => [
                        'type' => Type::string(),
                        'description' => '',
                    ],
                    'url' => [
                        'type' => Type::string(),
                        'description' => '',
                    ],

                    'notesCount' => ['type' => Type::int()]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

}