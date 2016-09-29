<?php namespace BibleExperience\Relay\Schema;

use BibleExperience\Relay\Queries\ViewerQuery;
use BibleExperience\Relay\Types\MutationType;
use GraphQL\Schema;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;

class BibleExchangeSchema
{
    public static function build()
    {
	
	$query = new ViewerQuery(new TypeResolver);	
      $schema = new Schema([
        'query' => $query,
        'mutation' => new MutationType($query->typeResolver),
        // Other possible options:
        // 'directives' => $directives
        // 'subscription' => $subscription,
        // 'types' => $types
      ]);

        return $schema;
    }
}
