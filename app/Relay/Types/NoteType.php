<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\StepType;
use BibleExperience\Relay\Types\LessonType;
use BibleExperience\Relay\Types\NoteCacheType;
use BibleExperience\Relay\Types\OwnerType;
use BibleExperience\Relay\Types\SimpleBibleVerseType;

use BibleExperience\Note as NoteModel;

class NoteType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Note',
            'description' => 'A note.',
            'fields' => [
                'id' => Relay::globalIdField(),
                'title' => ['type' => Type::string()],
                'tags' => ['type' => Type::listOf(Type::string())],
        		'tags_string' => ['type' => Type::string()],
        		'body' => ['type' => Type::string()],
        		'bible_verse_id' => ['type' => Type::int()],
        		'created_at' => ['type' => Type::string()],
        		'updated_at' => ['type' => Type::string()],
        		'output' => ['type' => $typeResolver->get(NoteCacheType::class)],
       		   'verse' => ['type' => $typeResolver->get(SimpleBibleVerseType::class)],
       		   'author' => ['type' => $typeResolver->get(OwnerType::class)]
            ],
           'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
