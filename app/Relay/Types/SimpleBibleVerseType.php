<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\BibleBookType as BibleBook;
use BibleExperience\Relay\Types\NoteType as Note;
use BibleExperience\Relay\Types\BibleChapterType as BibleChapter;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\Note as BibleNoteModel;

class SimpleBibleVerseType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'SimpleBibleVerse',
            'description' => 'A verse of the Holy Bible',
            'fields' => [
          	'id' => Relay::globalIdField(),
                'bookNumber' => ['type' => Type::int(),'description' => 'book order by'],
                'chapterNumber' => ['type' => Type::int(),'description' => 'chapter order by'],
                'verseNumber' => ['type' => Type::int(),'description' => 'verse order by'],
                'body' => [
                    'type' => Type::string(),
                    'description' => 'text of the verse',
                ],
                'biblechapter_id' => [
                    'type' => Type::int(),
                    'description' => '',
                ],
                'bible_version_id' => [
                    'type' => Type::int(),
                    'description' => '',
                ],
                'chapterURL' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'reference' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'url' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'quote' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'notesCount' => [
                    'type' => Type::int(),
                    'description' => '',
                ],
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

}
