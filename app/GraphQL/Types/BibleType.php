<?php

namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;

use BibleExperience\Bible;
use BibleExperience\GraphQL\Fields\BibleVerse as BibleVerseField;

class BibleType extends RelayType
{
    /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'Bible',
        'description' => 'The Holy Bible',
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
        return Bible::find($id);
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
			'abbreviation' => [
				'type' => Type::string(),
				'description' => ''
			],
			'language' => [
				'type' => Type::string(),
				'description' => ''
			],
			'books' => GraphQL::connection('bibleBook', 'books'),
			'verses' => GraphQL::connection('bibleVerse', 'verses'),
			//'verse' => BibleVerseField::field(),
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
