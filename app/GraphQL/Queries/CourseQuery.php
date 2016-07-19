<?php namespace BibleExperience\GraphQL\Queries;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLQuery;
use BibleExperience\Entities\Course;

class CourseQuery extends GraphQLQuery
{

    public function type()
    {
        return GraphQL::type('course');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],
			'student' => [
                'type' => Type::int(),
            ]
        ];
    }

    public function resolve($root, array $args)
    {
		return Course::find($args['id']);

    }
}