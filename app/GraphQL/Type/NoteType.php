<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use BibleExchange\Entities\User;

class NoteType extends GraphQLType {

	protected $attributes = [
		'name' => 'Note',
		'description' => 'A Note'
	];

	public function fields()
	{
		return [
			'id' => [
				'type' => Type::nonNull(Type::string()),
				'description' => 'The id of the note'
			],
			'body' => [
				'type' => Type::string(),
				'description' => 'The text of the bible verse'
			],
			'bible_verse_id' => [
				'type' => Type::string(),
				'description' => 'The Number of the bible verse in chapter'
			],
			'verse' => [
				'type' => Type::string(),
				'description' => 'Verse relationship. Verse of this note.'
			],
			'image_id' => [
				'type' => Type::string(),
				'description' => 'The chapter of origin in relation to the whole Bible.'
			],
			'user_id' => [
				'type' => Type::string(),
				'description' => 'User relationship. Creator of this note.'
			],
			'user' => [
				'type' => GraphQL::type('user'),
				'description' => 'User relationship. Creator of this note.'
			],
			'relatedObject' => [
				'type' => Type::string(),
				'description' => 'Related Object'
			],
			'object_type' => [
				'type' => Type::string(),
				'description' => 'Just the type name.'
			]
		];
	}

	// If you want to resolve the field yourself, you can declare a method
	// with the following format resolve[FIELD_NAME]Field()

	protected function resolveUserField($root, $args)
	{
		return $root->user;
	}

	protected function resolveVerseField($root, $args)
	{
		return $root->verse;
	}
	
}