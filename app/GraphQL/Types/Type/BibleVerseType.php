<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use BibleExchange\GraphQL\Support\Type as GraphQLType;
use BibleExchange\GraphQL\Type\NoteType;
use GraphQL;

class BibleVerseType extends GraphQLType {

	protected $attributes = [
		'name' => 'Bible Verse',
		'description' => 'A Bible verse'
	];

	public function fields()
	{
		return [
			'id' => [
				'type' => Type::nonNull(Type::string()),
				'description' => 'The id of the Bible verse'
			],
			'body' => [
				'type' => Type::string(),
				'description' => 'The text of the bible verse'
			],
			'b' => [
				'type' => Type::string(),
				'description' => 'book number this verse belongs to'
			],
			'c' => [
				'type' => Type::string(),
				'description' => 'chapter number this verse belongs to'
			],
			'v' => [
				'type' => Type::string(),
				'description' => 'The Number of the bible verse in chapter'
			],
			'bible_chapter_id' => [
				'type' => Type::string(),
				'description' => 'The chapter of origin in relation to the whole Bible.'
			],
			'reference' => [
				'type' => Type::string(),
				'description' => 'readable reference'
			],
			'url' => [
				'type' => Type::string(),
				'description' => 'url link'
			],
			'chapterURL' => [
				'type' => Type::string(),
				'description' => 'chapterURL link'
			],
			'notes' => [
				'type' => Type::listOf(GraphQL::type('note')),
				'description' => 'Notes relationship. Notes that belong to this verse'
			]
		];
	}

	// If you want to resolve the field yourself, you can declare a method
	// with the following format resolve[FIELD_NAME]Field()
	
	protected function resolveReferenceField($root, $args)
	{
		return $root->reference;
	}
	
	protected function resolveBodyField($root, $args)
	{
		return $root->t;
	}

}