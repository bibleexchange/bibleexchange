<?php

namespace BibleExperience\GraphQL\Fields;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\GraphQLField;
use Nuwave\Relay\Traits\GlobalIdTrait;

class AvatarField extends GraphQLField
{
    /**
     * Field attributes.
     *
     * @var array
     */
    protected $attributes = [
	    'name' => 'Avatar',
        'description' => 'Avatar of user.'
    ];

    /**
     * The return type of the field.
     *
     * @return Type
     */
    public function type()
    {
        return Type::string();
    }

    /**
     * Available field arguments.
     *
     * @return array
     */
    public function args()
    {
        return [
            'width' => [
                'type' => Type::int(),
                'description' => 'The width of the picture'
            ],
            'height' => [
                'type' => Type::int(),
                'description' => 'The height of the picture'
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
        $width = isset($args['width']) ? $args['width'] : 100;
        $height = isset($args['height']) ? $args['height'] : 100;

        return 'http://placehold.it/'.$root->id.'/'.$width.'x'.$height;
    }
}
