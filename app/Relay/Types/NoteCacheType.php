<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLRelay\Relay;

class NoteCacheType extends ObjectType {

 public function __construct()
    {
        return parent::__construct([
            'name' => 'NoteCache',
            'description' => 'Cache of a Note',
            'fields' => [
		    'id' => [
		            'type' => Type::id(),
		            'description' => '',
		    ],
		    'body' => [
		            'type' => Type::string(),
		            'description' => '',
		    ],
		    'note_id' => [
		            'type' => Type::int(),
		            'description' => '',
		    ],
		    'updated_at' => [
		            'type' => Type::string(),
		            'description' => '',
		    ],
		    'created_at' => [
		            'type' => Type::string(),
		            'description' => '',
		    ],
            ]
	]);
    }

}
