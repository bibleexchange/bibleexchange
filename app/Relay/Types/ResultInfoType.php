<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

class ResultInfoType extends ObjectType {

 public function __construct(TypeResolver $typeResolver)
    {

      $options = ["id","first","nextChapterURL","previousChapterURL","totalCount","perPage","totalPagesCount"];

      $fields = [];

      foreach($options AS $opt){
        $fields[$opt] = ['type' => Type::string()];
      }

        return parent::__construct([
           'name' => 'ResultInfo',
           'description' => "ResultInfo for a connection",
           'fields' => array_merge($fields, [
                    'hasNextPage' => [
                        'type' => Type::nonNull(Type::boolean()),
                        'description' => 'When paginating forwards, are there more items?'
                    ],
                    'hasPreviousPage' => [
                        'type' => Type::nonNull(Type::boolean()),
                        'description' => 'When paginating backwards, are there more items?'
                    ],
                    'startCursor' => [
                        'type' => Type::string(),
                        'description' => 'When paginating backwards, the cursor to continue.'
                    ],
                    'perPage' => [
                        'type' => Type::int(),
                        'description' => 'When paginating forwards, the cursor to continue.'
                    ],
                    'currentPage' => [
                        'type' => Type::int(),
                        'description' => 'When paginating forwards, the cursor to continue.'
                    ],
                    'totalCount' => [
                        'type' => Type::int(),
                        'description' => 'When paginating forwards, the cursor to continue.'
                    ],
                    'totalPagesCount' => [
                        'type' => Type::int(),
                        'description' => 'When paginating forwards, the cursor to continue.'
                    ]
           ]),
           'interfaces' => []
        ]);

    }

}