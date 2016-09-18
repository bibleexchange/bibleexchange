<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use Graphql;
    use BibleExperience\BibleBook;
    use BibleExperience\GraphQL\Type\BibleVerseType;

    class BibleChapterType extends GraphQLType {

            protected $attributes = [
        'name' => 'BibleChapter',
		'description' => 'A Bible chapter consists of verses'
    ];

        public function fields()
    {
        return [
			'id' => [
				'type' => Type::nonNull(Type::string()),
				'description' => 'The id of the Bible chapter'
			],
			'book_id' => [
				'type' => Type::string(),
				'description' => 'Parent book details in English'
			],
			'order_by' => [
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
			],
			'referenceSlug' => [
				'type' => Type::string(),
				'description' => 'the reference slug of the chapter'
			],
			'url' => [
				'type' => Type::string(),
				'description' => 'url for the chapter'
			],
			'book' => [
				'type' => GraphQL::type('bibleBook'),
				'description' => 'url for the chapter'
			],
			'nextChapter' => [
				'type' => GraphQL::type('bibleChapter'),
				'description' => 'The next chapter after this chapter'
			],
			'previousChapter' => [
				'type' => GraphQL::type('bibleChapter'),
				'description' => 'The previous chapter before this chapter'
			],
			'verses' => [
				'type' => Type::listOf(GraphQL::type('bibleVerse')),
				'description' => 'Verses relationship. Verses that belong to this chapter'
			],
			'notes' => [
				'type' => Type::listOf(GraphQL::type('note')),
				'description' => 'Notes relationship. Notes that belong to this chapter'
			],
			'verseCount' => [
				'type' => Type::int(),
				'description' => ''
			],
		];
    }
	
}
