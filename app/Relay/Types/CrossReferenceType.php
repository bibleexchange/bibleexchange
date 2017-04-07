<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\BibleBookType as BibleBook;
use BibleExperience\Relay\Types\CrossReferenceType;
use BibleExperience\Relay\Types\NoteConnectionType;
use BibleExperience\Relay\Types\BibleChapterType as BibleChapter;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\Note as BibleNoteModel;

class CrossReferenceType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

      $defaultArgs = GraphQLGenerator::defaultArgs();
      //$bibleVersesConnectionType = GraphQLGenerator::connectionType($typeResolver, BibleVerseType::class);

        return parent::__construct([
            'name' => 'CrossReference',
            'description' => 'A cross reference to a Bible Verse',
            'fields' => [
          	   'id' => Relay::globalIdField(),
                'bible_verse_id' => ['type' => Type::int(),'description' => ''],
                'rank' => ['type' => Type::int(),'description' => ''],
                'start_verse' => ['type' => Type::int(),'description' => ''],
                'end_verse' => ['type' => Type::int(),  'description' => ''],
                'reference' => ['type' => Type::string(),'description' => ''],/*,
                'verses' => [
                    'type' =>  $typeResolver->get($bibleVersesConnectionType),
                    'description' => 'The verses of this cross reference.',
                    'args' => $defaultArgs,
                    'resolve' => function($root, $args, $resolveInfo){
                        return $this->paginatedConnection($root->verses, $args);
                      }
                ],*/
                
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

}