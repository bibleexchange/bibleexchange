<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\BibleChapterType as BibleChapter;

use BibleExperience\BibleBook as BibleBookModel;
use BibleExperience\BibleChapter as BibleChapterModel;

class BibleBookType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

      $bibleChaptersConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(BibleChapter::class)]);

        return parent::__construct([
            'name' => 'BibleBook',
            'description' => 'A book of the Holy Bible',
            'fields' => [
          		  'id' => Relay::globalIdField(),
                'title' => [
                    'type' => Type::string(),
                    'description' => 'Name of the Book of the Bible',
                ],
                'slug' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                't' => [
                    'type' => Type::string(),
                    'description' => 'Testament of the Book of the Bible.',
                ],
                'g' => [
                    'type' => Type::int(),
                    'description' => 'Genre ID of the book of the Bible',
                ],
                'chapterCount' => [
                    'type' => Type::int(),
                    'description' => 'The number of Chapters in this book of the Bible',
                ],
                'chapters' => [
                    'type' =>  $bibleChaptersConnection['connectionType'],
                    'description' => 'The chapters of this book of the Bible.',
                    'args' => Relay::connectionArgs(),
                    'resolve' => function($book, $args, $resolveInfo){
                      if(is_array($book)){
                        $chapters = BibleChapterModel::where('bible_book_id',$book['id'])->orderBy('order_by')->get();
                        return $this->paginatedConnection($chapters, $args);
                      }

                  }
                ]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = BibleBookModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }
}

/*



*/
