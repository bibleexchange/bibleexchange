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
use BibleExperience\Relay\Types\CourseType AS Course;
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
      return

    }

    public static function destroy(TypeResolver $typeResolver){

      return
    }

public static function update(TypeResolver $typeResolver){

  return 
}

}
