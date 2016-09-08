<?php

namespace BibleExperience\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLQuery;

use Auth;
use BibleExperience\User;

class ViewerQuery extends GraphQLQuery
{
    /**
     * Type query returns.
     *
     * @return Type
     */
    public function type()
    {
        return GraphQL::type('user');
    }

    /**
     * Available query arguments.
     *
     * @return array
     */
    public function args()
    {
        return [
		'id' => [
                'type' => Type::int(),
            	],
		'token' => [
                'type' => Type::string(),
            	]
		];
    }

    /**
     * Resolve the query.
     *
     * @param  mixed  $root
     * @param  array  $args
     * @return mixed
     */
    public function resolve($root, array $args)
    {

	$user = User::find(5);
	Auth::login($user);
	return Auth::user();
	
        //if ( $token = \JWTAuth::parseToken()){return $token->authenticate();}
	/*
	if(Auth::check()){
	  return Auth::user();
	}else if(isset($args['token'])){
	  $user = User::where('remember_token','==',$args['token'])->first();
		return response()->json(['error'=>'message from me '], 401);
		if($user !== null){
			Auth::login($user, true);
			return $user;
		}else{
			return User::getGuest();
		}
	}else {
	  return User::getGuest();
	}
*/
    }
}
