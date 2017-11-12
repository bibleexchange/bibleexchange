<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\ResourceSectionType;
use BibleExperience\Relay\Support\PaginatedCollection;

use BibleExperience\BibleChapter as BibleChapterModel;

class ResourceType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
        return parent::__construct([
            'name' => 'Resource',
            'description' => 'A Resource',
            'fields' => [
          	    'id' => Relay::globalIdField(),
                'title' => ['type' => Type::string()],
                'author' => ['type' => Type::string()],
                'text' => ['type' => Type::string()],
                'sections' => [
                    'type' => GraphQLGenerator::resolveConnectionType($typeResolver, ResourceSectionType::class),
                      'args' => GraphQLGenerator::paginationArgs(),
                      'resolve' => function($root, $args, $resolveInfo){
                                return new PaginatedCollection($args, $root->sections());
                            },
                ]

            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }
}
