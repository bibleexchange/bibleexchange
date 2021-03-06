<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\BibleBookType as BibleBook;
use BibleExperience\Relay\Types\CrossReferenceType;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\Relay\Types\SimpleBibleChapterType as BibleChapter;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\Note as BibleNoteModel;

class BibleVerseType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

      $defaultArgs = GraphQLGenerator::defaultArgs();
      $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);
      $crossReferenceConnectionType = GraphQLGenerator::connectionType($typeResolver, CrossReferenceType::class);

        return parent::__construct([
            'name' => 'BibleVerse',
            'description' => 'A verse of the Holy Bible',
            'fields' => [
          	   'id' => Relay::globalIdField(),

                'book' => [
                    'type' => $typeResolver->get(BibleBook::class),
                    'resolve' => function($root){
                        return $root->book;
                    }
                ],

                'chapter' => [
                    'type' => $typeResolver->get(BibleChapter::class),
                    'resolve' => function($root){
                        return $root->chapter;
                    }
                ],
                'bookNumber' => ['type' => Type::int(),'description' => 'book order by'],
                'chapterNumber' => ['type' => Type::int(),'description' => 'chapter order by'],
                'verseNumber' => ['type' => Type::int(),'description' => 'verse order by'],
                'body' => ['type' => Type::string(),  'description' => 'text of the verse'],
                'biblechapter_id' => ['type' => Type::int(),'description' => ''],
                'bible_version_id' => ['type' => Type::int(),'description' => ''],
                'chapterURL' => ['type' => Type::string(),'description' => ''],
                'reference' => ['type' => Type::string(),'description' => ''],
                'url' => ['type' => Type::string(),'description' => ''],
                'quote' => ['type' => Type::string()],
                'notesCount' => ['type' => Type::int()],

                'next' => [
                    'type' => $typeResolver->get(BibleVerseType::class)
                ],
                'previous' => [
                    'type' => $typeResolver->get(BibleVerseType::class)
                ],
               
               'notes' => [
                    'type' => $typeResolver->get($notesConnectionType),
                    'description' => 'Notes Application Wide.',
                    'args' => $defaultArgs,
                    'resolve' => function($root, $args, $resolveInfo){
    			              return $this->paginatedConnection($root->notes, $args);
    			          },
                ],
               'crossReferences' => [
                    'type' => $typeResolver->get($crossReferenceConnectionType),
                    'description' => 'crossReferences.',
                    'args' => $defaultArgs,
                    'resolve' => function($root, $args, $resolveInfo){
                              return $this->paginatedConnection($root->crossReferences, $args);
                          },
                ],
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

    

}

