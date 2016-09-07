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
        $user = \JWTAuth::parseToken()->authenticate();

	if($user !== null){ return $user;}	

		if(Auth::check()){
			return Auth::user();
		}else{
			return User::getGuest();
		}
    }
}
