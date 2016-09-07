<?php namespace BibleExperience\GraphQL\Queries;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLQuery;
use BibleExperience\Bible;

class BibleQuery extends GraphQLQuery
{

    public function type()
    {
        return GraphQL::type('bible');
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

		if(isset($args['version']) && $args['version'] !== null){
			$query = Bible::where('abbreviation',$args['version'])->first();
			
			if($query !== null){
				return $query;
			}
			
		}
		
		if(isset($args['id']) && $args['id'] !== null){
			
			$bible = Bible::find($args['id']);
			
			if($bible !== null){
				return $bible;
			}
			
		}
		
		return Bible::find(1);
		
    }
}
