<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;

use BibleExperience\Relay\Types\ActivityType;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\NodeType;

class StatementType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {
        return parent::__construct([
            'name' => 'Statement',
            'description' => 'Statement of a users Experience with an activity.',
            'fields' => [
          	   'id' => Relay::globalIdField(),
                'user' => ['type' => $typeResolver->get(UserType::class),'description' => 'user this experience belongs to.'],
                'verb' => ['type' => Type::string(),'description' => 'Action taken by user.'],
                'activity' => ['type' =>  $typeResolver->get(ActivityType::class),'description' => 'Activity action was taken upon by user.'],
            ],
           'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}