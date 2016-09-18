<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use BibleExperience\Step;
    use GraphQL;

    use BibleExperience\Bible;

class BibleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Bible',
        'description' => 'The Holy Bible',
    ];

   
    public function fields()
    {
        return [
		'id' => [
			'type' => Type::nonNull(Type::string()),
			'description' => 'The id of the course'
		],
		'abbreviation' => [
			'type' => Type::string(),
			'description' => ''
		],
		'language' => [
			'type' => Type::string(),
			'description' => ''
		],
		'books' => [
			'type' => Type::listOf(GraphQL::type('bibleBook')),
			'description' => ''
		],
		'verses' => [
			'type' => Type::listOf(GraphQL::type('bibleVerse')),
			'description' => ''
		]
	];
    }

}
