<?php namespace BibleExperience\Relay\Schema;

use BibleExperience\Relay\Queries\ViewerQuery;
use GraphQL\Schema;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;

class BibleExchangeSchema
{
    public static function build()
    {

      $schema = new Schema([
        'query' => new ViewerQuery(new TypeResolver),
        'mutation' => null,
        // Other possible options:
        // 'directives' => $directives
        // 'subscription' => $subscription,
        // 'types' => $types
      ]);

        return $schema;
    }
}
