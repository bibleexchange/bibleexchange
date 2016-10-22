<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\BibleChapterType as BibleChapter;

use BibleExperience\BibleBook as BibleBookModel;
use BibleExperience\BibleChapter as BibleChapterModel;

class BibleBookType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

         $defaultArgs = GraphQLGenerator::defaultArgs();
	 $bibleChaptersConnectionType = GraphQLGenerator::connectionType($typeResolver, BibleVerseType::class);

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
                    'type' =>  $typeResolver->get($bibleChaptersConnectionType),
                    'description' => 'The chapters of this book of the Bible.',
                    'args' => $defaultArgs,
                    'resolve' => function($book, $args, $resolveInfo){
                        $chapters = $book->chapters()->orderBy('order_by')->get();
                        return $this->paginatedConnection($chapters, $args);
                    }
                  ]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }
}
