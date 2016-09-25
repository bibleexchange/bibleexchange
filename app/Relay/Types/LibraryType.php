<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Models\StarWarsData;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\Definition\RelayType;

use BibleExperience\Relay\Types\CourseType as Course;
use BibleExperience\Relay\Types\NodeType as Node;

use BibleExperience\Library AS LibraryModel;
use GraphQLRelay\Relay;

class LibraryType extends  ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

	$coursesConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(Course::class)]);

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
                    'type' =>  $coursesConnection['connectionType'],
                    'description' => 'The courses of the Library.',
            	    'args' => Relay::connectionArgs(),
            	    'resolve' => function($root, $args){
                        return $this->paginatedConnection($root->courses, $args);
            	    }
                ]
	     ],
            'interfaces' => [$typeResolver->get(Node::class)]

        ]);
    }

   public static function modelFind($id,  $typeClass){
    	$model = LibraryModel::find($id);
    	$model->relayType =  $typeClass;
    	return $model;
   }

 }
