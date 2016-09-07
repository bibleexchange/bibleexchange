<?php

namespace BibleExperience\GraphQL\Fields;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLField;
use Nuwave\Relay\Traits\GlobalIdTrait;

class StepField extends GraphQLField
{
    /**
     * Field attributes.
     *
     * @var array
     */
    protected $attributes = [
        'description' => 'Course Steps'
    ];

    /**
     * The return type of the field.
     *
     * @return Type
     */
    public function type()
    {
         return GraphQL::type('step');
    }

    /**
     * Available field arguments.
     *
     * @return array
     */
    public function args()
    {
        return [
            'orderBy' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The orderBy of the step.'
            ]
	];
    }

    /**
     * Resolve the field.
     *
     * @param  mixed $root
     * @param  array  $args
     * @return mixed
     */
    public function resolve($root, array $args)
    {
	return $root->steps()->where('order_by',$args['orderBy'])->first();
    }
}
