<?php

namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\Course;

class ProgressType extends RelayType
{
    /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'Course progress',
        'description' => 'A course\'s progress.',
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
        return Course::find($id);
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
				'description' => 'The id of the course'
			],
			'bible_verse_id' => [
				'type' => Type::int(),
				'description' => ''
			],
			'title' => [
				'type' => Type::string(),
				'description' => ''
			],
			'description' => [
				'type' => Type::string(),
				'description' => ''
			],
			'image_id' => [
				'type' => Type::int(),
				'description' => 'T'
			],
			'user_id' => [
				'type' => Type::int(),
				'description' => 'errors'
			],
			'year' => [
				'type' => Type::int(),
				'description' => ''
			],
			'modules' => GraphQL::connection('module', 'modules'),
			'created_at' => [
				'type' => Type::string(),
				'description' => ''
			],
			'updated_at' => [
				'type' => Type::string(),
				'description' => ''
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
