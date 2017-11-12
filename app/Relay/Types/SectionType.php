<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Support\PaginatedCollection;
use BibleExperience\Relay\Types\CrossReferenceType;

use BibleExperience\BibleChapter as BibleChapterModel;

class ResourceSectionType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
      $crossReferenceConnectionType = GraphQLGenerator::connectionType($typeResolver, CrossReferenceType::class);

        return parent::__construct([
            'name' => 'ResourceSection',
            'description' => 'A Resource',
            'fields' => [
          	    'id' => Relay::globalIdField(),
                'text' => ['type' => Type::string()],
                'crossReferences' => [
                    'type' => $typeResolver->get($crossReferenceConnectionType),
                    'description' => 'crossReferences.',
                    'args' => GraphQLGenerator::defaultArgs(),
                    'resolve' => function($root, $args, $resolveInfo){
                            return new PaginatedCollection($args, $root->crossReferences());
                          },
                ],

            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }
}
