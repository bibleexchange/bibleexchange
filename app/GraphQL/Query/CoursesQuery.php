<?php namespace BibleExperience\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLQuery;
use BibleExperience\Course;

class CoursesQuery extends GraphQLQuery
{

  protected $attributes = [
    'name' => 'courses'
  ];

    public function type()
    {
        return Type::listOf(GraphQL::type('course'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()]
        ];
    }

    public function resolve($root, array $args)
    {
	    if(isset($args['id']))
            {
                return Course::where('id' , $args['id'])->get();
            }
            else
            {
                return Course::all();
            }	
    }
}
