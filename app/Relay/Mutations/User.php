<?php namespace BibleExperience\Relay\Mutations;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\ErrorType;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\User as UserModel;

class User {

    public static function create(TypeResolver $typeResolver){

      return Relay::mutationWithClientMutationId([
    	    'name' => 'SignUpUser',
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
          		    'type' => Type::string(),
          		    'resolve' => function ($payload) {
          		        return $payload['error'];
          		    }
          		],
          		'code' => [
          		    'type' => Type::string(),
          		    'resolve' => function ($payload) {
          		        return $payload['code'];
          		    }
          		],
          		'user' => [
          		    'type' => $typeResolver->get(UserType::class),
          		    'resolve' => function ($payload) {
          		        return $payload['user'];
          		    }
          		]
          ],
          'mutateAndGetPayload' => function ($input) {
          		$newAuth = UserModel::signup($input['email'], $input['password']);
          		return [
          		    'token' => $newAuth['token'],
          		    'error' => $newAuth['error'],
          		    'code' => $newAuth['code'],
           		    'user' => $newAuth['user'],
          		];
          	    }
          	]);

    }

}
