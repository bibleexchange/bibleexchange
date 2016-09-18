<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use GraphQL;

    use BibleExperience\Bible;

class NoteType extends GraphQLType
{
    protected $attributes = [
		'name' => 'Note',
		'description' => 'A Note'
    ];

   
    public function fields()
    {
        return [
			'id' => [
				'type' => Type::nonNull(Type::int()),
				'description' => 'The id of the note'
			],
			'body' => [
				'type' => Type::string(),
				'description' => ''
			],
			'bible_verse_id' => [
				'type' => Type::int(),
				'description' => ''
			],
			'verse' => [
				'type' => Type::int(),
				'description' => 'Verse relationship. Verse of this note.'
			],
			'image_id' => [
				'type' => Type::int(),
				'description' => ''
			],
			'user_id' => [
				'type' => Type::int(),
				'description' => 'User relationship. Creator of this note.'
			],
			'user' => [
				'type' => GraphQL::type('user'),
				'description' => 'User relationship. Creator of this note.'
			]
		];
    }
	
}
