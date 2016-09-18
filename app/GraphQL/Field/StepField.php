<?php namespace BibleExperience\GraphQL\Field;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Field;
use GraphQL;

class StepField extends Field {

        protected $attributes = [
        'description' => 'A step'
    ];

    public function type(){
        return GraphQL::type('step');
    }

    public function args()
    {
        return [
            'orderBy' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The orderBy of the step.'
            ]
	];
    }

    protected function resolve($root, $args)
    {
       return $root->steps()->where('order_by',$args['orderBy'])->first();
    }

}
