<?php namespace BibleExperience\Relay\Mutations;

//use GraphQL\Type\Definition\EnumType;
//use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;

use BibleExperience\Relay\Types\LessonType;

use BibleExperience\Lesson as LessonModel;

class Lesson {

    public static function create(TypeResolver $typeResolver){
      return Relay::mutationWithClientMutationId([
    	    'name' => 'LessonCreate',
    	    'inputFields' => [
    		'id' => [
    		    'type' => Type::nonNull(Type::string())
    		],
    		'title' => [
    		    'type' => Type::string()
    		],
    		'summary' => [
    		    'type' =>  Type::string()
    		],
    		'course_id' => [
    		    'type' =>  Type::nonNull(Type::string())
    		],
    		'order_by' => [
    		    'type' =>  Type::int()
    		]
    	    ],
    	    'outputFields' => [
    		'error' => [
    		    'type' => Type::string(),
    		    'resolve' => function ($payload) {
    		        return $payload['error'];
    		    }
    		],
    		'code' => [
    		    'type' => Type::string(),
    		    'resolve' => function ($payload) {
    		        return $payload['code'];
    		    }
    		],
    		'lesson' => [
    		    'type' => $typeResolver->get(LessonType::class),
    		    'resolve' => function ($payload) {
    		        return $payload['lesson'];
    		    }
    		]
    	    ],
    	    'mutateAndGetPayload' => function ($input) {
    		$input['course_id'] =  $this->decodeGlobalId($input['course_id'])['id'];
    		$new = LessonModel::createFromArray($input);
    		return [
    		    'error' => $new['error'],
    		    'code' => $new['code'],
     		    'lesson' => $new['lesson'],
    		];
    	    }
    	]);


    }

    public static function destroy(TypeResolver $typeResolver){

      return null;
    }

public static function update(TypeResolver $typeResolver){

  return  Relay::mutationWithClientMutationId([
	    'name' => 'LessonUpdate',
	    'inputFields' => [
		'id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'title' => [
		    'type' => Type::string()
		],
		'summary' => [
		    'type' =>  Type::string()
		],
		'course_id' => [
		    'type' =>  Type::int()
		],
		'order_by' => [
		    'type' =>  Type::int()
		]
	    ],
	    'outputFields' => [
		'error' => [
		    'type' => Type::string(),
		    'resolve' => function ($payload) {
		        return $payload['error'];
		    }
		],
		'code' => [
		    'type' => Type::string(),
		    'resolve' => function ($payload) {
		        return $payload['code'];
		    }
		],
		'lesson' => [
		    'type' => $typeResolver->get(LessonType::class),
		    'resolve' => function ($payload) {
		        return $payload['lesson'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$input['id'] =  $this->decodeGlobalId($input['id'])['id'];

		$new = LessonModel::updateFromArray($input);
		return [
		    'error' => $new['error'],
		    'code' => $new['code'],
 		    'lesson' => $new['lesson'],
		];
	    }
	]);

}

}
