<?php namespace BibleExperience\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\GraphQL\Support\Definition\GraphQLQuery;
use BibleExperience\GraphQL\Traits\GlobalIdTrait;
use RelayContainer;
use BibleExperience\Course;

class CourseQuery extends GraphQLQuery
{
    use GlobalIdTrait;

    /**
     * Associated GraphQL Type.
     *
     * @return mixed
     */
    public function type()
    {
        return GraphQL::type('course');
    }

    /**
     * Arguments available on node query.
     *
     * @return array
     */
    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id())
            ]
        ];
    }

    /**
     * Resolve query.
     *
     * @param  string $root
     * @param  array $args
     * @return Illuminate\Database\Eloquent\Model|array
     */
    public function resolve($root, array $args, ResolveInfo $info)
    {
	    if(isset($args['id']))
            {
                return Course::find($args['id']);
            }
            else
            {
                return null;
            }	
    }
}
