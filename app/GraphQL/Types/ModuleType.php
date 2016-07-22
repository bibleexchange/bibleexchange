<?php

namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\Module;

class ModuleType extends RelayType
{
    /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'Module',
        'description' => 'A module is a list of chapters.',
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
        return Module::find($id);
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
				'description' => 'The id of the module'
			],
			'title' => [
				'type' => Type::string(),
				'description' => ''
			],
			'course_id' => [
				'type' => Type::int(),
				'description' => ''
			],
			'order_by' => [
				'type' => Type::int(),
				'description' => ''
			],
			'created_at' => [
				'type' => Type::string(),
				'description' => ''
			],
			'updated_at' => [
				'type' => Type::string(),
				'description' => ''
			],
			'chapters' => GraphQL::connection('chapter', 'chapters'),
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
