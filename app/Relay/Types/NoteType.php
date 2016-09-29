<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

use BibleExperience\Relay\Types\StepAttachmentType as StepAttachment;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\LessonNoteType;
use BibleExperience\Relay\Types\NoteCacheType;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\SimpleBibleVerseType;

use BibleExperience\Note as NoteModel;

class NoteType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Note',
            'description' => 'A note of a lesson.',
            'fields' => [
                'id' => Relay::globalIdField(),
                'tags' => [
                 'type' => Type::listOf(Type::string()),
                 'description' => ''
                ],
    		'cached' => [
    			'type' => Type::string(),
    			'description' => ''
    		],
    		'body' => [
    			'type' => Type::string(),
    			'description' => ''
    		],
    		'output' => [
    			'type' => $typeResolver->get(NoteCacheType::class),
    			'description' => 'Processed body of note'
    		],
    		'type' => [
    			'type' => Type::string(),
    			'description' => ''
    		],
    		'course_id' => [
    			'type' => Type::int(),
    			'description' => 'errors'
    		],
    		'bible_verse_id' => [
    			'type' => Type::int(),
    			'description' => 'id of the Bible Verse'
    		],
    		'verse' => [
    			'type' => $typeResolver->get(SimpleBibleVerseType::class),
    			'description' => ''
    		],
    		'author' => [
    			'type' => $typeResolver->get(UserType::class),
    			'description' => 'author id of this note'
    		],
    		'pivot' => [
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
    		]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = NoteModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }

}
