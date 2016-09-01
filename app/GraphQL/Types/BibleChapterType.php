<?php namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\BibleBook;
use BibleExperience\GraphQL\Type\BibleVerseType;

class BibleChapterType extends RelayType {
	
	  /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
        'name' => 'BibleChapter',
		'description' => 'A Bible chapter consists of verses'
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
				'description' => 'The id of the Bible chapter'
			],
			'book_id' => [
				'type' => Type::string(),
				'description' => 'Parent book details in English'
			],
			'order_by' => [
				'type' => Type::string(),
				'description' => 'Sequence of this chapter in the context of its book'
			],
			'summary' => [
				'type' => Type::string(),
				'description' => 'a short description of the chapter'
			],
			'reference' => [
				'type' => Type::string(),
				'description' => 'the reference of the chapter'
			],
			'url' => [
				'type' => Type::string(),
				'description' => 'url for the chapter'
			],
			'book' => [
				'type' => GraphQL::type('bibleBook'),
				'description' => 'url for the chapter'
			],
			'nextChapter' => [
				'type' => Type::listOf(Type::string()),
				'description' => 'The next chapter after this chapter'
			],
			'previousChapter' => [
				'type' => Type::listOf(Type::string()),
				'description' => 'The previous chapter before this chapter'
			],
			'verses' => [
				'type' => Type::listOf(GraphQL::type('bibleVerse')),
				'description' => 'Verses relationship. Verses that belong to this chapter'
			],
			'notes' => [
				'type' => Type::listOf(GraphQL::type('note')),
				'description' => 'Notes relationship. Notes that belong to this chapter'
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