<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\NodeType as Node;

class BibleVerse2Type extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {

         return parent::__construct([
            'name' => 'BibleVerse2',
            'description' => 'A verse of the Holy Bible',
            'fields' => [
          	   'id' => Relay::globalIdField(),
                'bookNumber' => ['type' => Type::int(),'description' => 'book order by'],
                'chapterNumber' => ['type' => Type::int(),'description' => 'chapter order by'],
                'verseNumber' => ['type' => Type::int(),'description' => 'verse order by'],
                'body' => ['type' => Type::string(),  'description' => 'text of the verse'],
                'biblechapter_id' => ['type' => Type::int(),'description' => ''],
                'bible_version_id' => ['type' => Type::int(),'description' => ''],
                'chapterURL' => ['type' => Type::string(),'description' => ''],
                'reference' => ['type' => Type::string(),'description' => ''],
                'url' => ['type' => Type::string(),'description' => ''],
                'quote' => ['type' => Type::string()]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

}

