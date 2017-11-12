<?php namespace BibleExperience\Relay\Mutations;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\ErrorType;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\Relay\Types\ViewerType;
use BibleExperience\User as UserModel;
use BibleExperience\Viewer;

class User {

    public static function create(TypeResolver $typeResolver){

      return Relay::mutationWithClientMutationId([
    	    'name' => 'CreateUser',
    	    'inputFields' => [
          		'email' => [
          		    'type' => Type::nonNull(Type::string())
          		],
          		'password' => [
          		    'type' =>  Type::nonNull(Type::string())
          		]
          	    ],
          'outputFields' => [
          		'token' => [
          		    'type' => Type::string(),
          		    'resolve' => function ($payload) {
          		        return $payload['token'];
          		    }
          		],
            'error' => [
                'type' => $typeResolver->get(ErrorType::class),
                'resolve' => function ($payload) {
                    return $payload['error'];
                }
            ],
          		'viewer' => [
          		    'type' => $typeResolver->get(ViewerType::class),
          		    'resolve' => function ($payload) {
          		        return $payload['viewer'];
          		    }
          		]
          ],
          'mutateAndGetPayload' => function ($input) {
          		$newAuth = UserModel::signup($input['email'], $input['password']);

              if($newAuth->error->code === 200){

                $newAuth = UserModel::login($newAuth->user);

                return [
          		    'token' => $newAuth->token,
          		    'error' => $newAuth->error,
           		    'viewer' =>  new Viewer($newAuth)
          		];

            }else{


                return [
                  'token' => $newAuth->token,
                  'error' => $newAuth->error,
                  'viewer' =>  new Viewer($newAuth)
              ];

            }
          	    }
          	]);

    }

}
