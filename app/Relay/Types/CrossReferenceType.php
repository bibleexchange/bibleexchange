<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use BibleExperience\Relay\Support\PaginatedCollection;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\BibleVerse2Type;
use BibleExperience\Relay\Types\NodeType as Node;

class CrossReferenceType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'CrossReference',
            'description' => 'A cross reference to a Bible Verse',
            'fields' => [
          	   'id' => Relay::globalIdField(),
                'bible_verse_id' => ['type' => Type::int(),'description' => ''],
                'rank' => ['type' => Type::int(),'description' => ''],
                'start_verse' => ['type' => Type::int(),'description' => ''],
                'end_verse' => ['type' => Type::int(),  'description' => ''],
                'reference' => ['type' => Type::string(),'description' => ''],
                'url' => ['type' => Type::string(),'description' => ''],
                'verses' => [
                    'type' =>  GraphQLGenerator::resolveConnectionType($typeResolver, BibleVerse2Type::class),
                    'description' => 'The verses of this cross reference.',
                    'args' => GraphQLGenerator::paginationArgs(),
                    'resolve' => function($root, $args, $resolveInfo){
                        return new PaginatedCollection($args, $root->verses());
                      }
                ],
                
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }
}
