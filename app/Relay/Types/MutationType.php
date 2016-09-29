<?php namespace BibleExperience\Relay\Types;

//use GraphQL\Type\Definition\EnumType;
//use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\UserType AS User;

use BibleExperience\User as UserModel;

class MutationType extends ObjectType {

    public function __construct(TypeResolver $typeResolver)
    {

	$loginMutation = Relay::mutationWithClientMutationId([
	    'name' => 'LoginUser',
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
		    'type' => $typeResolver->get(User::class),
		    'resolve' => function ($payload) {
		        return $payload['user'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$newAuth = UserModel::login($input['email'], $input['password']);
		return [
		    'token' => $newAuth['token'],
		    'error' => $newAuth['error'],
		    'code' => $newAuth['code'],
 		    'user' => $newAuth['user'],
		];
	    }
	]);

        return parent::__construct([
            'name' => 'Mutation',
                'fields' => function () use ($loginMutation) {
		   return [
		    'loginUser' => $loginMutation
		   ];
		}
	]);

    }

}

