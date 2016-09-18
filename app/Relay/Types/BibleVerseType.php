<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\BibleBookType as BibleBook;
use BibleExperience\Relay\Types\BibleNoteType as BibleNote;
use BibleExperience\Relay\Types\BibleChapterType as BibleChapter;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\Note as BibleNoteModel;

class BibleVerseType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

  $notesConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(BibleNote::class)]);

        return parent::__construct([
            'name' => 'BibleVerse',
            'description' => 'A verse of the Holy Bible',
            'fields' => [
          	   'id' => Relay::globalIdField(),
                'b' => [
                    'type' => Type::int(),
                    'description' => 'book order by',
                ],
                'c' => [
                    'type' => Type::int(),
                    'description' => 'chapter order by',
                ],
                'v' => [
                    'type' => Type::int(),
                    'description' => 'verse order by',
                ],
                't' => [
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
                'book' => [
                    'type' => $typeResolver->get(BibleBook::class),
                    'description' => '',
                ],
                'chapter' => [
                    'type' => $typeResolver->get(BibleChapter::class),
                    'description' => '',
                ],
                'notes' => [
                    'type' =>  $notesConnection['connectionType'],
                    'description' => 'The verses of this chapter of the Bible.',
                    'args' => Relay::connectionArgs(),
                    'resolve' => function($root, $args, $resolveInfo){

                      if(is_array($root)){
                        $notes = BibleNoteModel::where('bible_verse_id',$root['id'])->get();
                        return $this->paginatedConnection($notes, $args);
                      }else if(is_object($root)){
                        $notes = $root->notes;
                        return $this->paginatedConnection($notes, $args);
                      }

                  }
                ]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = BibleVerseModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }

}
