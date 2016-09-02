<?php

namespace BibleExperience\GraphQL\Fields;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLField;
use Nuwave\Relay\Traits\GlobalIdTrait;

class BibleVerse extends GraphQLField
{
    /**
     * Field attributes.
     *
     * @var array
     */
    protected $attributes = [
        'description' => 'A verse of the Holy Bible'
    ];

    /**
     * The return type of the field.
     *
     * @return Type
     */
    public function type()
    {
       return Type::objectType();
    }

    /**
     * Available field arguments.
     *
     * @return array
     */
    public function args()
    {
        return [
		  'reference' => [
                'type' => Type::string(),
                'description' => 'reference for bible verse'
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
        // TODO: Resolve field
		dd($root->verses[0]);
    }
}
