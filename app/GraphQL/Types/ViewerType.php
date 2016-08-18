<?php

namespace BibleExperience\GraphQL\Types;

use GraphQL;
use Relay;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\User;

class ViewerType extends RelayType
{
    /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'Viewer',
        'description' => 'A viewer of the application.',
    ];

	 /**
     * Get the identifier of the type.
     *
     * @param  mixed $obj
     * @return mixed
     */
    public function getIdentifier($obj)
    {
		return $obj->id;
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
        return new Viewer($id);
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
				'description' => 'The jwt token of the viewer when logged in.'
			],
			'auth' => [
				'type' => GraphQL::type('user'),
				'description' => 'The id of the user'
			]
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