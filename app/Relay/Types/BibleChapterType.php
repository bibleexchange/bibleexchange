<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\BibleVerseType as BibleVerse;

use BibleExperience\BibleChapter as BibleChapterModel;

class BibleChapterType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

  	 $defaultArgs = GraphQLGenerator::defaultArgs();
	 $bibleVersesConnectionType = GraphQLGenerator::connectionType($typeResolver, BibleVerseType::class);
	 $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);

        return parent::__construct([
            'name' => 'BibleChapter',
            'description' => 'A chapter of a book of the Holy Bible',
            'fields' => [
          	'id' => Relay::globalIdField(),
                'book_id' => [
                    'type' => Type::int(),
                    'description' => '',
                ],
                'verseCount' => [
                    'type' => Type::int(),
                    'description' => '',
                ],
                'order_by' => [
                    'type' => Type::int(),
                    'description' => '',
                ],
                'reference' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'referenceSlug' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'url' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'nextChapter' => [
                    'type' => $typeResolver->get(BibleChapterType::class),
                    'description' => '',
                ],
                'previousChapter' => [
                    'type' => $typeResolver->get(BibleChapterType::class),
                    'description' => '',
                ],
                'verses' => [
                    'type' =>  $typeResolver->get($bibleVersesConnectionType),
                    'description' => 'The verses of this chapter of the Bible.',
                    'args' => $defaultArgs,
                    'resolve' => function($root, $args, $resolveInfo){
                        return $this->paginatedConnection($root->verses, $args);
                      }
                ],
                'notes' => [
                    'type' => $typeResolver->get($notesConnectionType),
                      'description' => 'Notes Application Wide.',
                      'args' => $defaultArgs,
                      'resolve' => function($root, $args, $resolveInfo){
    			                return $this->paginatedConnection($root->notes($args, false), $args);
    			            },
                ]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }
}
