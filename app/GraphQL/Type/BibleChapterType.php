<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use BibleExchange\GraphQL\Type\BibleVerseType;
use GraphQL;

class BibleChapterType extends GraphQLType {

	protected $attributes = [
		'name' => 'Bible Chapter',
		'description' => 'A Bible chapter consists of verses'
	];

	public function fields()
	{

		return [
			'id' => [
				'type' => Type::nonNull(Type::string()),
				'description' => 'The id of the Bible chapter'
			],
			'key_english_id' => [
				'type' => Type::string(),
				'description' => 'Parent book details in English'
			],
			'orderBy' => [
				'type' => Type::string(),
				'description' => 'Sequence of this chapter in the context of its book'
			],
			'summary' => [
				'type' => Type::string(),
				'description' => 'a short description of the chapter'
			],
			'reference' => [
				'type' => Type::string(),
				'description' => 'the reference of the chapter'
			]/*,
			'nextChapter' => [
				'type' => GraphQL::type('biblechapter'),
				'description' => 'The next chapter after this chapter'
			]/*,
			'previousChapter' => [
				'type' => GraphQL::type('biblechapter'),
				'description' => 'The previous chapter before this chapter'
			]*/,
			'verses' => [
				'type' => Type::listOf(GraphQL::type('bibleverse')),
				'description' => 'Verses relationship. Verses that belong to this chapter'
			]
		];
	}
	
	protected function resolveNextChapterField($root, $args)
	{
		return $root->reference;
	}
	
}