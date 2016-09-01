<?php namespace BibleExperience\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Nuwave\Relay\Support\Definition\RelayType;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\BibleVerse;
use BibleExperience\User;

class NoteType extends RelayType {

	  /**
     * Attributes of Type.
     *
     * @var array
     */
    protected $attributes = [
		'name' => 'Note',
		'description' => 'A Note'
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
        return Note::find($id);
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
				'description' => 'The id of the note'
			],
			'body' => [
				'type' => Type::string(),
				'description' => 'The text of the bible verse'
			],
			'bible_verse_id' => [
				'type' => Type::string(),
				'description' => 'The Number of the bible verse in chapter'
			],
			'verse' => [
				'type' => Type::string(),
				'description' => 'Verse relationship. Verse of this note.'
			],
			'image_id' => [
				'type' => Type::string(),
				'description' => 'The chapter of origin in relation to the whole Bible.'
			],
			'user_id' => [
				'type' => Type::string(),
				'description' => 'User relationship. Creator of this note.'
			],
			'user' => [
				'type' => GraphQL::type('user'),
				'description' => 'User relationship. Creator of this note.'
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
	
	//////

		protected function resolveUserField($root, $args)
	{
		return $root->user;
	}

	protected function resolveVerseField($root, $args)
	{
		return $root->verse;
	}
	
}