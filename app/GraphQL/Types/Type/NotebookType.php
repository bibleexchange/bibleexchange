<?php namespace BibleExperience\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use BibleExperience\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use BibleExperience\Entities\User;

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
			
			'url' => [
				'type' => Type::string(),
				'description' => 'URL'
			],
			'owner' => [
				'type' => GraphQL::type('user'),
				'description' => 'User relationship. Creator of this note.'
			]
		];
	}

}