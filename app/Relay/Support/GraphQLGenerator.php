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

  public static function simpleArgs(){
    return ['id' => ['type' => Type::string() ]];
  }

  public static function simpleField($name, $type, $args, $model, $id){
       return  [
            'type' =>  $type,
            'description' => $name . ' that matches Id.',
            'args' => $args,
            'resolve' => function($root, $args){
                 return $model::find($id);
            },
    ];

  }

}


//$typeResolver->get(CourseType::class)
//simpleField($name, $type, $args, $model)
//$this->decodeRelayId($args['id'])
