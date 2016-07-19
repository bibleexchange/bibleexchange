<?php namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\Entities\Notification;

class NotificationType extends RelayType {

    /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'Notification',
        'description' => 'A notification',
    ];
	
	 /**
     * Get model by id.
     *
     * When the root 'node' query is called, it will use this method
     * to resolve the type by providing the id.
     *
     * @param  string $id
     * @return \Eloquence\Database\Model
     */
    public function resolveById($id)
    {
        return Notification::find($id);
    }

     public function relayFields()
    {
        return [
			'id' => [
				'type' => Type::nonNull(Type::string()),
				'description' => 'The id of the notification'
			],
			'sender_id' => [
				'type' => Type::string(),
				'description' => 'sender_id'
			],
			'user_id' => [
				'type' => Type::string(),
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
				'type' => Type::string(),
				'description' => 'object_id token'
			],
			'object_type' => [
				'type' => Type::string(),
				'description' => 'object_type of the user'
			],
			'sent_at' => [
				'type' => Type::string(),
				'description' => 'sent_at of the user'
			]
		];
    }
    
}