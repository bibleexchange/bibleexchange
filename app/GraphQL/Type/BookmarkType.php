<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use GraphQL;

class BookmarkType extends GraphQLType
{
    protected $attributes = [
	'name' => 'Bookmark',
	'description' => 'An Application-Wide Bookmark'
    ];
   
    public function fields()
    {
        return [
		'id' => [
			'type' => Type::nonNull(Type::string()),
			'description' => 'The id of the bookmark'
		],
		'url' => [
			'type' => Type::string(),
			'description' => 'The url bookmarked.'
		],
		'user_id' => [
			'type' => Type::string(),
			'description' => 'User relationship. Creator of this bookmark.'
		],
		'created_at' => [
			'type' => Type::string(),
			'description' => 'When bookmark was created.'
		],
		'updated_at' => [
			'type' => Type::string(),
			'description' => 'When bookmark was last updated.'
		],			
		'user' => [
			'type' => GraphQL::type('user'),
			'description' => 'User relationship. Creator of this bookmark.'
		]
	];
    }

}
