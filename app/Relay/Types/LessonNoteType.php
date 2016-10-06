<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\NoteType;

use BibleExperience\LessonNote as LessonNoteModel;

class LessonNoteType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'LessonNote',
            'description' => 'A note of a lesson.',
            'fields' => [
          	'id' => Relay::globalIdField(),
		'lesson_id' => [
			'type' => Type::string(),
			'description' => ''
		],
		'note_id' => [
			'type' => Type::string(),
			'description' => ''
		],
		'note' => [
			'type' => $typeResolver->get(NoteType::class),
			'description' => ''
		],
		'order_by' => [
			'type' => Type::int(),
			'description' => ''
		],
		'next' => [
			'type' => $typeResolver->get(LessonNoteType::class),
			'description' => ''
		],
		'previous' => [
			'type' => $typeResolver->get(LessonNoteType::class),
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
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = LessonNoteModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }

}
