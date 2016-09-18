<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\UserType as User;
use BibleExperience\Relay\Types\NotePropertyType as NoteProperty;

use BibleExperience\Note as BibleNoteModel;

class NotePropertyType extends ObjectType {

 public function __construct()
    {
        return parent::__construct([
            'name' => 'NoteProperty',
            'description' => 'Properties of Note',
            'fields' => [
		    'resourceUrl' => [
		            'type' => Type::string(),
		            'description' => '',
		    ],
		    'text' => [
		            'type' => Type::string(),
		            'description' => '',
		    ],
		    'tags' => [
		            'type' => Type::listOf(Type::string()),
		            'description' => '',
		    ],
		    'links' => [
		            'type' => Type::listOf(Type::string()),
		            'description' => '',
		    ],
            ]
	]);
    }

}
