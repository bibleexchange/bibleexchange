<?php namespace BibleExperience\GraphQL\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLQuery;
use BibleExperience\BibleVerse;

class BibleVerseQuery extends GraphQLQuery
{

    public function type()
    {
        return GraphQL::type('bibleVerse');
    }

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

    public function resolve($root, array $args)
    {
	if(isset($args['id'])){return BibleVerse::find($args['id']);}
	if(isset($args['reference'])){return BibleVerse::findByReference($args['reference']);}
	return new BibleVerse;		
    }
}
