<?php namespace BibleExperience\Relay\Support;

use BibleExperience\Relay\Types\ConnectionType;
use BibleExperience\Relay\Types\EdgeType;
use GraphQLRelay\Relay;
use GraphQL\Type\Definition\Type;

class GraphQLGenerator {

  public static function resolveConnectionType($typeResolver, $typeClass){
    return $typeResolver->get(new ConnectionType($typeResolver, $typeClass));
  }

  public static function connectionType($typeResolver, $typeClass){
    return new ConnectionType($typeResolver, $typeClass);
  }

  public static function edgeType($typeResolver, $typeClass){
    return new EdgeType($typeResolver, $typeClass);
  }

  public static function defaultArgs(){
    return array_merge(Relay::connectionArgs(), ['filter' => ['type' => Type::string()], 'id' => ['type' => Type::string()], 'token' => ['type' => Type::string()] ]);
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

      public static function encodeGlobalId($type, $id)
    {
        return Relay::toGlobalId($type, $id);
    }

    /**
     * Decode the global id.
     *
     * @param  string $id
     * @return array
     */
    public static function decodeGlobalId($globalId)
    {
  return Relay::fromGlobalId($globalId);
    }

    /**
     * Get the decoded GraphQL Type.
     *
     * @param  string $id
     * @return string
     */
    public static function decodeRelayType($id)
    {
        $result = Self::decodeGlobalId($id);
         return $result['type'];
    }


    /**
     * Get the decoded id.
     *
     * @param  string $id
     * @return string
     */
    public static function decodeRelayId($id)
    {
      $result = Self::decodeGlobalId($id);
      return $result['id'];
    }

        public static function decodeId($id)
        {
          $result = Self::decodeGlobalId($id);

          if($result['id'] === false || $result['id'] === ""){
            $result['id'] = (int) $id;
          }

          return $result['id'];
        }

        protected static function getCursorId($cursor)
        {
            return (int)Self::decodeRelayId($cursor);
        }

        public static function makeCursor($string)
        {
            return (string)base64_encode($string);
        }

         public static function decodeCursor($cursor)
        {
            return (int)base64_decode($cursor);
        } 

 function findOne($args, $model){
    $id = GraphQLGenerator::decodeId($args['id']);
    return $model::find($id);    
  }

  public static function paginationArgs(){

    return 
        [
            'after' => ['type' => Type::string()], 
            'first' => ['type' => Type::int()],
            'before' => ['type' => Type::string()], 
            'last' => ['type' => Type::int()],  
            'filter' => ['type' => Type::string()], 
            'id' => ['type' => Type::string()], 
            'orderBy' => ['type' => Type::string()],
            'page'=> ['type' => Type::int()],
            'perPage'=> ['type' => Type::int()]
        ];

  }

}