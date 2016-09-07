<?php

namespace BibleExperience\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLQuery;

use BibleExperience\BibleChapter;

class BibleChapterQuery extends GraphQLQuery
{
    /**
     * Type query returns.
     *
     * @return Type
     */
    public function type()
    {
        return GraphQL::type('bibleChapter');
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
			'version' => [
                'type' => Type::string(),
            ],
			'reference' => [
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
		if(isset($args['reference'])){
			return BibleChapter::findByReference($args['reference']);
		}else if(isset($args['id'])){
			return BibleChapter::find($args['id']);
		}else{
			return new BibleChapter;
		}
    }
}
