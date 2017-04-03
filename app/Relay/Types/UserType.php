<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\NavHistoryType as NavHistory;
use BibleExperience\Relay\Types\AuthType as Auth;

use BibleExperience\User AS UserModel;

class UserType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

      $navHistoryConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(NavHistory::class)]);

        return parent::__construct([
            'name' => 'User',
            'description' => '',
            'fields' => [
          	'id' => Relay::globalIdField(),
                'name' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'email' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'verified' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'role' => [
                    'type' => Type::int(),
                    'description' => '',
                ],
                'password' => [
                    'type' => Type::int(),
                    'description' => '',
                ],
                'remember_token' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'token' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'nickname' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'url' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'token' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'lastStep' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'authenticated' => [
                    'type' =>Type::boolean()
                ],
                'dataID' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'navHistory' => [
                    'type' =>  $navHistoryConnection['connectionType'],
                    'description' => '',
                    'args' => Relay::connectionArgs(),
                    'resolve' => function($root, $args, $resolveInfo){

                      if(is_array($root)){
                        $navs = UserModel::where('id',$root['id'])->first()->navHistory;
                        return $this->paginatedConnection(collect($navs), $args);
                      }else if(is_object($root)){
			$navs = $root->navHistory;
			return  $this->paginatedConnection(collect($navs), $args);
		      }

                  }
                ]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model =UserModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }
}

/*



*/
