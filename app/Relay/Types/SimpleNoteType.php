<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\NoteCacheType;
use BibleExperience\Relay\Types\SimpleBibleVerseType;

use BibleExperience\Note as NoteModel;

class SimpleNoteType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

	$defaultArgs = GraphQLGenerator::defaultArgs();

        return parent::__construct([
            'name' => 'SimpleNote',
            'description' => 'A note.',
            'fields' => [
                'id' => Relay::globalIdField(),
                'title' => ['type' => Type::string()],
                'tags' => ['type' => Type::listOf(Type::string())],
        		'tags_string' => ['type' => Type::string()],
        		'body' => ['type' => Type::string()],
        		'type' => ['type' => Type::string()],
        		'bible_verse_id' => ['type' => Type::int()],
        		'created_at' => ['type' => Type::string()],
        		'updated_at' => ['type' => Type::string()],
        		'output' => ['type' => $typeResolver->get(NoteCacheType::class),'description' => 'Processed body of note'],
        		'verse' => ['type' => $typeResolver->get(SimpleBibleVerseType::class)],
            ],
           'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
