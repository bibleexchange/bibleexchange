<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use BibleExchange\Entities\User;

class NotebookType extends GraphQLType {

	protected $attributes = [
		'name' => 'Notebook',
		'description' => 'A Notebook'
	];

	public function fields()
	{
		return [
			'id' => [
				'type' => Type::nonNull(Type::string()),
				'description' => 'The id of the note'
			],
			'title' => [
				'type' => Type::string(),
				'description' => 'The title of this notebook'
			],
			'bible_verse_id' => [
				'type' => Type::string(),
				'description' => 'The main bible verse text of this notebook.'
			],
			'notes' => [
				'type' => Type::listOf(GraphQL::type('note')),
				'description' => 'Notes relationship. Notes that belong to this notebook'
			],
			'user_id' => [
				'type' => Type::string(),
				'description' => 'User relationship. Creator of this note.'
			],
			'user' => [
				'type' => GraphQL::type('user'),
				'description' => 'User relationship. Creator of this note.'
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