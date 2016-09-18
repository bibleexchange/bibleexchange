<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use GraphQL;

class BibleVerseType extends GraphQLType
{
    protected $attributes = [
	'name' => 'BibleVerse',
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
			'notesCount' => [
				'type' => Type::int(),
				'description' => 'count of notes'
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
	
}
