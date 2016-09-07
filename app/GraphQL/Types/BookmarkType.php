<?php

namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\Bookmark;

class BookmarkType extends RelayType
{
    /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
	'name' => 'Bookmark',
	'description' => 'An Application-Wide Bookmark'
    ];

    /**
     * Get model by id.
     *
     * When the root 'node' query is called, it will use this method
     * to resolve the type by providing the id.
     *
     * @param  string $id
     * @return \Eloquence\Database\Model
     */
    public function resolveById($id)
    {
        return Bookmark::find($id);
    }

    /**
     * Available fields of Type.
     *
     * @return array
     */
    public function relayFields()
    {
        return [
		'id' => [
			'type' => Type::nonNull(Type::string()),
			'description' => 'The id of the bookmark'
		],
		'url' => [
			'type' => Type::string(),
			'description' => 'The url bookmarked.'
		],
		'user_id' => [
			'type' => Type::string(),
			'description' => 'User relationship. Creator of this bookmark.'
		],
		'created_at' => [
			'type' => Type::string(),
			'description' => 'When bookmark was created.'
		],
		'updated_at' => [
			'type' => Type::string(),
			'description' => 'When bookmark was last updated.'
		],			
		'user' => [
			'type' => GraphQL::type('user'),
			'description' => 'User relationship. Creator of this bookmark.'
		]
];
    }

    /**
     * List of related connections.
     *
     * @return array
     */
    public function connections()
    {
        return [];
    }
}
