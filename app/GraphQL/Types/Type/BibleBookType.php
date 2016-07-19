<?php namespace BibleExperience\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use BibleExperience\GraphQL\Support\Type as GraphQLType;

class BibleBookType extends GraphQLType {

	protected $attributes = [
		'name' => 'Bible Book',
		'description' => 'A Bible book'
	];

	public function fields()
	{
		return [
			'id' => [
				'type' => Type::nonNull(Type::string()),
				'description' => 'The id of the Bible book'
			],
			'n' => [
				'type' => Type::string(),
				'description' => 'The title of the bible book'
			],
			't' => [
				'type' => Type::string(),
				'description' => 'The testament the books belongs to.'
			],
			'g' => [
				'type' => Type::string(),
				'description' => 'not sure yet!!'
			]
		];
	}

	// If you want to resolve the field yourself, you can declare a method
	// with the following format resolve[FIELD_NAME]Field()
	
	/*
	protected function resolveReferenceField($root, $args)
	{
		return $root->reference;
	}
	*/

}