<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use BibleExchange\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use BibleExchange\Entities\User;

class BookmarkType extends GraphQLType {

	protected $attributes = [
		'name' => 'Bookmark',
		'description' => 'An Application-Wide Bookmark'
	];

	public function fields()
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

	// If you want to resolve the field yourself, you can declare a method
	// with the following format resolve[FIELD_NAME]Field()

	protected function resolveUserField($root, $args)
	{
		return $root->user;
	}

}