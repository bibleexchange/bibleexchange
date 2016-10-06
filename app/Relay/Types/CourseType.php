<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\BibleVerseType as BibleVerse;
use BibleExperience\Relay\Types\LessonType as Lesson;
use BibleExperience\Relay\Types\UserType as User;

use BibleExperience\Course as CourseModel;
use BibleExperience\Course as LessonModel;

class CourseType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
  $lessonsConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(Lesson::class)]);

        return parent::__construct([
            'name' => 'Course',
            'description' => 'A course.',
            'fields' => [
          	'id' => Relay::globalIdField(),
       		'identifier' => [
			'type' => Type::int(),
			'description' => ''
		],
		'uuid' => [
			'type' => Type::string(),
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
		'description' => [
			'type' => Type::string(),
			'description' => ''
		],
		'image_id' => [
			'type' => Type::int(),
			'description' => 'T'
		],
		'owner' => [
			'type' => $typeResolver->get(User::class),
			'description' => ''
		],
		'lessonsCount' => [
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
            'lessons' => [
                    'type' => $typeResolver->get($lessonsConnection['connectionType']),
                    'description' => 'The lessons of this course.',
                    'args' => Relay::connectionArgs(),
                    'resolve' => function($root, $args, $resolveInfo){
                        return $this->paginatedConnection($root->lessons()->orderBy('order_by')->get(), $args);
                    }
                ],
              'lesson' => [
                  'type' => $typeResolver->get(Lesson::class),
                  'args' => [
                      'id' => [
                          'name' => 'id',
                          'description' => 'id of the lesson.',
                          'type' => Type::nonNull(Type::string())
                      ]
                  ],
                  'resolve' => function ($root, $args){
		     $decoded = $this->decodeGlobalId($args['id']);

                        if(is_array($decoded) && isset($decoded['id']) ){
                          $lesson = $root->lessons()->where('id',$decoded['id'])->first();
                        }else{
                          $lesson = $root->lessons()->where('id',$args['id'])->first();
                        }

			  if($lesson === null){
				$lesson = new LessonModel;
			  }

			return $lesson;

                  }
              ],
            ],
          'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = CourseModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }

}
