<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\BibleVerseType as BibleVerse;

use BibleExperience\BibleChapter as BibleChapterModel;

class BibleChapterType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
  $bibleVersesConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(BibleVerse::class)]);
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
                    'type' =>  $bibleVersesConnection['connectionType'],
                    'description' => 'The verses of this chapter of the Bible.',
                    'args' => Relay::connectionArgs(),
                    'resolve' => function($root, $args, $resolveInfo){

                      if(is_array($root)){
                        $verses = BibleChapterModel::where('bible_book_id',$book['id'])->orderBy('order_by')->get();
                        return $this->paginatedConnection($verses, $args);
                      }else if(is_object($root)){
                        return $this->paginatedConnection($root->verses, $args);
                      }

                  }
                ]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = BibleChapterModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }

}
