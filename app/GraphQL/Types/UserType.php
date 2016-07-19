<?php

namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\Entities\User;

class UserType extends RelayType
{
    /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user of the application.',
    ];

	 /**
     * Get the identifier of the type.
     *
     * @param  mixed $obj
     * @return mixed
     */
    public function getIdentifier($obj)
    {
        return $obj['id'];
    }
	
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
        return User::find($id);
    }

    /**
     * Available fields of Type.
     *
     * @return array
     */
    public function relayFields()
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
			'token' => [
				'type' => Type::string(),
				'description' => 'JWT token'
			],
			'lastStep' => [
				'type' => GraphQL::type('step'),
				'description' => ''
			]
			//'notifications' => GraphQL::connection('notification', 'notifications'),
			//'gravatar' =>  BibleExperience\GraphQL\Fields\AvatarField::class
		];
    }
   
   /**
     * Available connections for type.
     *
     * @return array
     */
    protected function connections()
    {
        return [];
    }
}
