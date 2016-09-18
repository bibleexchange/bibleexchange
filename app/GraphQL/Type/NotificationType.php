<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use GraphQL;

class NotificationType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Notification',
        'description' => 'A notification',
    ];
   
    public function fields()
    {
        return [
		'id' => [
			'type' => Type::nonNull(Type::int()),
			'description' => 'The id of the notification'
		],
		'sender_id' => [
			'type' => Type::int(),
			'description' => 'sender_id'
		],
		'user_id' => [
			'type' => Type::int(),
			'description' => 'user_id'
		],
		'type' => [
			'type' => Type::string(),
			'description' => 'The type'
		],
		'subject' => [
			'type' => Type::string(),
			'description' => 'The subject'
		],
		'body' => [
			'type' => Type::string(),
			'description' => 'body'
		],
		'object_id' => [
			'type' => Type::int(),
			'description' => 'object_id token'
		],
		'object_type' => [
			'type' => Type::string(),
			'description' => 'object_type of the user'
		],
		'sent_at' => [
			'type' => Type::string(),
			'description' => 'sent_at of the user'
		]];
    }
}
