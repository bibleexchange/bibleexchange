<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\BibleVerseType as BibleVerse;
use BibleExperience\Relay\Types\LessonNoteType as LessonNote;
use BibleExperience\Relay\Types\UserType as User;

use BibleExperience\Lesson as LessonModel;

class LessonType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
  $notesConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(LessonNote::class)]);

        return parent::__construct([
            'name' => 'Lesson',
            'description' => 'A lesson of a course.',
            'fields' => [
          	'id' => Relay::globalIdField(),
       		'identifier' => [
		'type' => Type::int(),
			'description' => ''
		],
		'verse' => [
			'type' => $typeResolver->get(BibleVerse::class),
			'description' => ''
		],
		'title' => [
			'type' => Type::string(),
			'description' => ''
		],
		'summary' => [
			'type' => Type::string(),
			'description' => ''
		],
		'order_by' => [
			'type' => Type::int(),
			'description' => ''
		],
		'notesCount' => [
			'type' => Type::int(),
			'description' => ''
		],
		'created_at' => [
			'type' => Type::string(),
			'description' => ''
		],
		'updated_at' => [
			'type' => Type::string(),
			'description' => ''
		],
            'notes' => [
                    'type' => $typeResolver->get($notesConnection['connectionType']),
                    'description' => 'The steps of this course.',
                    'args' => Relay::connectionArgs(),
                    'resolve' => function($root, $args, $resolveInfo){

                      if(is_array($root)){
                        $notes = LessonModel::where('id',$root['id'])->get()->notes;
                        return $this->paginatedConnection($notes, $args);
                      }else if(is_object($root)){
                        return $this->paginatedConnection($root->notes, $args);
                      }

                  }
                ]
            ],
          'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = LessonModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }

}
