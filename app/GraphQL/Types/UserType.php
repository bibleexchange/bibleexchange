<?php

namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;

use BibleExperience\User;

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
			'name' => [
				'type' => Type::string(),
				'description' => 'The name of user'
			],
			'verified' => [
				'type' => Type::string(),
				'description' => ''
			],
			'role' => [
				'type' => Type::string(),
				'description' => ''
			],
			'remember_token' => [
				'type' => Type::string(),
				'description' => ''
			],
			'password' => [
				'type' => Type::string(),
				'description' => ''
			],
			'authenticated' => [
				'type' => Type::boolean(),
				'description' => ''
			],
		];
    }

    /**
     * List of related connections.
     *
     * @return array
     */
    public function connections()
    {
        return [];
    }
}
