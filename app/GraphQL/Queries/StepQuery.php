<?php namespace BibleExperience\GraphQL\Queries;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLQuery;
use BibleExperience\Step;

class StepQuery extends GraphQLQuery
{

    public function type()
    {
        return GraphQL::type('step');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],
	    'orderBy' => [
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args)
    {
	if(isset($args['id'])){
	  return Step::find($args['id']);
	}else{
	  $arr = explode('_',$args['orderBy']);

	  return Step::where('course_id',$arr[0])->where('order_by',$arr[1])->first();
	}

    }
}
