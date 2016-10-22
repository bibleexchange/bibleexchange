<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Models\StarWarsData;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\Definition\RelayType;

use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\CourseType as Course;
use BibleExperience\Relay\Types\NodeType as Node;

use BibleExperience\Library AS LibraryModel;
use GraphQLRelay\Relay;

class LibraryType extends  ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

	$coursesConnectionType = GraphQLGenerator::connectionType($typeResolver, CourseType::class);
 	$defaultArgs = array_merge(Relay::connectionArgs(), ['filter' => ['type' => Type::string()], 'id' => ['type' => Type::string()] ]);

        return parent::__construct([
            'name' => 'Library',
            'description' => 'A library',
            'fields' => [
		            'id' => Relay::globalIdField(),
                'title' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'description' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'created_at' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'updated_at' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
		'courses' => [
                    'type' =>  $typeResolver->get($coursesConnectionType),
                    'description' => 'The courses of the Library.',
                    'args' => $defaultArgs,
                    'resolve' => function($root, $args){
                      return $this->paginatedConnection($root->courses()->where('public',1)->get(), $args);
                     }
                ]
	     ],
            'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }
 }
