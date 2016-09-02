<?php namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\BibleVerse;

class BibleVerseType extends RelayType {

	  /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
		'name' => 'BibleVerse',
		'description' => 'A Bible verse'
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
        return BibleVerse::find($id);
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
				'description' => 'The id of the Bible verse'
			],
			't' => [
				'type' => Type::string(),
				'description' => 'The text of the bible verse'
			],
			'b' => [
				'type' => Type::string(),
				'description' => 'book number this verse belongs to'
			],
			'c' => [
				'type' => Type::string(),
				'description' => 'chapter number this verse belongs to'
			],
			'v' => [
				'type' => Type::string(),
				'description' => 'The Number of the bible verse in chapter'
			],
			'bible_chapter_id' => [
				'type' => Type::string(),
				'description' => 'The chapter of origin in relation to the whole Bible.'
			],
			'reference' => [
				'type' => Type::string(),
				'description' => 'readable reference'
			],
			'url' => [
				'type' => Type::string(),
				'description' => 'url link'
			],
			'chapterURL' => [
				'type' => Type::string(),
				'description' => 'chapterURL link'
			],
			'notes' => [
				'type' => Type::listOf(GraphQL::type('note')),
				'description' => 'Notes relationship. Notes that belong to this verse'
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