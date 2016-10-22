<?php namespace BibleExperience\Relay\Support;

use BibleExperience\Relay\Types\ConnectionType;
use GraphQLRelay\Relay;
use GraphQL\Type\Definition\Type;

class GraphQLGenerator {

  public static function connectionType($typeResolver, $typeClass){
    return new ConnectionType($typeResolver, $typeClass);
  }

  public static function defaultArgs(){
    return array_merge(Relay::connectionArgs(), ['filter' => ['type' => Type::string()], 'id' => ['type' => Type::string()] ]);
  }


}
