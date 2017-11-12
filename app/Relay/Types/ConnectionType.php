<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use GraphQL\Type\Definition\Type;

use BibleExperience\Relay\Types\PageInfoType;

class ConnectionType extends ObjectType {

 public function __construct(TypeResolver $typeResolver, $nodeType)
    {
      $connection = Relay::connectionType([
	      'nodeType' => $typeResolver->get($nodeType),
	      'connectionFields' => [
      		'resultsInfo' => ['type' => $typeResolver->get(PageInfoType::class)]
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