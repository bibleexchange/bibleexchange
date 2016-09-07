<?php namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\BibleVerse;
use BibleExperience\User;

class NavHistoryType extends RelayType {

	  /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
		'name' => 'NavHistory',
		'description' => 'Users Navigation History'
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
        return User::navHistory[$id];
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
				'type' => Type::nonNull(Type::int()),
				'description' => 'The id of the nav'
			],
			'url' => [
				'type' => Type::string(),
				'description' => 'The text of the bible verse'
			],
			'title' => [
				'type' => Type::string(),
				'description' => 'The text of the bible verse'
			],
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
