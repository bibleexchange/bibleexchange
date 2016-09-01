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
        if(Auth::check()){
			return Auth::user();
		}else{
			return new User;
		}
    }
}
