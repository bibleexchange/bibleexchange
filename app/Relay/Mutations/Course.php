<?php namespace BibleExperience\Relay\Mutations;

//use GraphQL\Type\Definition\EnumType;
//use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;

use BibleExperience\Relay\Types\BibleVerseType AS BibleVerse;
use BibleExperience\Relay\Types\UserType AS User;
use BibleExperience\Relay\Types\CourseType AS CourseType;
use BibleExperience\Relay\Types\LessonType AS Lesson;
use BibleExperience\Relay\Types\StepType AS Step;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\Relay\Types\ErrorType AS Error;

use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\User as UserModel;
use BibleExperience\Course as CourseModel;
use BibleExperience\Lesson as LessonModel;
use BibleExperience\Step as StepModel;
use BibleExperience\Note as NoteModel;

class Course {

    public static function create(TypeResolver $typeResolver){
      return null;

    }

    public static function destroy(TypeResolver $typeResolver){

      return null;
    }

  public static function update(TypeResolver $typeResolver){

    return Relay::mutationWithClientMutationId([
  	    'name' => 'UpdateCourse',
  	    'inputFields' => [

  		'id' => [
  		    'type' => Type::nonNull(Type::string())
  		],
  		'title' => [
  		    'type' => Type::string()
  		],
  		'bible_verse_id' => [
  		    'type' =>  Type::string()
  		],
  		'description' => [
  		    'type' =>  Type::string()
  		],
  		'public' => [
  		    'type' =>  Type::boolean()
  		],
  		'image' => [
  		    'type' =>  Type::string()
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
  		'course' => [
  		    'type' => $typeResolver->get(CourseType::class),
  		    'resolve' => function ($payload) {
  		        return $payload['course'];
  		    }
  		]
  	    ],
  	    'mutateAndGetPayload' => function ($input) {
  		$input['id'] =  $this->decodeGlobalId($input['id'])['id'];

  		$new = CourseModel::updateFromArray($input);

  		return [
  		    'error' => $new['error'],
  		    'code' => $new['code'],
   		    'course' => $new['course'],
  		];
  	    }
  	]);

  }

}
