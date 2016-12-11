<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\User as UserModel;

class NavHistoryType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'NavHistory',
            'description' => 'A users navigation history',
            'fields' => [
          	'id' => Relay::globalIdField(),
                'url' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'title' => [
                    'type' => Type::string(),
                    'description' => '',
                ]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	//$model = UserModel::navHistory();
        	//$model->relayType =  $typeClass;
        	//return $model;
       }

}
