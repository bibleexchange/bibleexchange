<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use GraphQL\Type\Definition\Type;

class ConnectionType extends ObjectType {

 public function __construct(TypeResolver $typeResolver, $nodeType)
    {
      $connection = Relay::connectionType([
	      'nodeType' => $typeResolver->get($nodeType),
	      'connectionFields' => [
		'totalCount' => ['type' => Type::int()],
		'perPage' => ['type' => Type::int()],
		'totalPagesCount' => ['type' => Type::int()],
		'currentPage' => ['type' => Type::int()],
	      ]
	    ]);

        return parent::__construct([
            'name' => $connection->config['name'],
            'description' => $connection->config['description'],
            'fields' => $connection->config['fields'],
           'interfaces' => []
        ]);

    }

}
