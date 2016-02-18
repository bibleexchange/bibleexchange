<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

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
			't' => [
				'type' => Type::string(),
				'description' => 'The text of the bible verse'
			],
			'bible_chapter_id' => [
				'type' => Type::string(),
				'description' => 'The chapter of origin in relation to the whole Bible.'
			],
			'reference' => [
				'type' => Type::string(),
				'description' => 'readable reference'
			]
		];
	}

	// If you want to resolve the field yourself, you can declare a method
	// with the following format resolve[FIELD_NAME]Field()
	
	protected function resolveReferenceField($root, $args)
	{
		return $root->reference;
	}

}