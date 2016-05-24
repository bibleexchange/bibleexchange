<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use BibleExchange\GraphQL\Support\Type as GraphQLType;
use GraphQL;

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
			],
			'unreadNotifications' => [
				'type' => Type::listOf(GraphQL::type('notification')),
				'description' => 'Notifications of the user'
			],
			'gravatar' => [
				'type' => Type::string(),
				'description' => 'gravatar'
			]
			
			
		];
	}

	// If you want to resolve the field yourself, you can declare a method
	// with the following format resolve[FIELD_NAME]Field()
	protected function resolveEmailField($root, $args)
	{
		return strtolower($root->email);
	}
	
	protected function resolveUnreadNotificationsField($root, $args)
	{
				
		$notifications_all = new \BibleExchange\Entities\NotificationFetcher($root);
		
		$notifications = $notifications_all->onlyUnread()->fetch();
		
		return $notifications;
	}

	protected function resolveGravatarField($root, $args)
	{
		return $root->present()->gravatar(30);
	}
	
}