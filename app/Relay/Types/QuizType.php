<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\NodeType;

class QuizType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Quiz',
            'description' => 'A quiz over a lesson.',
            'fields' => [
            	'id' => Relay::globalIdField(),
          		'title' => ['type' => Type::string()],
          		'solution' => ['type' => Type::string()],
              'questions' => ['type' => Type::string()],
          		'created_at' => ['type' => Type::string()],
          		'updated_at' => ['type' => Type::string()]         	
            ],
          'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
