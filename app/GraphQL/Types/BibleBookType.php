<?php

namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\BibleBook;

class BibleBookType extends RelayType
{
    /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'BibleBook',
        'description' => 'A Bible Book is a list of chapters.',
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
        return BibleBook::find($id);
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
			'n' => [
				'type' => Type::string(),
				'description' => ''
			],
			't' => [
				'type' => Type::int(),
				'description' => ''
			],
			'g' => [
				'type' => Type::int(),
				'description' => ''
			],
			'chapters' => GraphQL::connection('bibleChapter', 'chapters'),
			'chapterCount' => [
				'type' => Type::int(),
				'description' => ''
			],
		];
    }
 
}
