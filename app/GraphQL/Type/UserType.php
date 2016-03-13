<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType {

	protected $attributes = [
		'name' => 'User',
		'description' => 'A user'
	];

	public function fields()
	{
		return [
			'id' => [
				'type' => Type::nonNull(Type::string()),
				'description' => 'The id of the user'
			],
			'email' => [
				'type' => Type::string(),
				'description' => 'The email of user'
			],
			'firstname' => [
				'type' => Type::string(),
				'description' => 'The first name of user'
			],
			'lastname' => [
				'type' => Type::string(),
				'description' => 'The last name of user'
			],
			'username' => [
				'type' => Type::string(),
				'description' => 'The username of user'
			],
			'error' => [
				'type' => Type::string(),
				'description' => 'errors'
			],
			'token' => [
				'type' => Type::string(),
				'description' => 'JWT token'
			]
		];
	}

	// If you want to resolve the field yourself, you can declare a method
	// with the following format resolve[FIELD_NAME]Field()
	protected function resolveEmailField($root, $args)
	{
		return strtolower($root->email);
	}

}