<?php namespace BibleExperience\Relay\Types;

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
use BibleExperience\Relay\Types\NoteType AS Note;
use BibleExperience\Relay\Types\ErrorType AS Error;

use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\User as UserModel;
use BibleExperience\Course as CourseModel;
use BibleExperience\Lesson as LessonModel;
use BibleExperience\Step as StepModel;
use BibleExperience\Note as NoteModel;

use BibleExperience\Relay\Mutations\Course as CourseMutation;
use BibleExperience\Relay\Mutations\Lesson as LessonMutation;
use BibleExperience\Relay\Mutations\Note as NoteMutation;
use BibleExperience\Relay\Mutations\Token as TokenMutation;
use BibleExperience\Relay\Mutations\User as UserMutation;

class MutationType extends ObjectType {

use GlobalIdTrait;

    public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Mutation',
                'fields' => function () use ($typeResolver) {
            		   return [
            		    'createToken' => TokenMutation::create($typeResolver),
                    'signUpUser' => UserMutation::create($typeResolver),
            		    'courseUpdate' =>CourseMutation::update($typeResolver),
            		    'lessonUpdate' => LessonMutation::update($typeResolver),
            		    'lessonCreate' => LessonMutation::create($typeResolver),
            		    'noteCreate' => NoteMutation::create($typeResolver),
            		    'noteUpdate' => NoteMutation::update($typeResolver),
            		    'noteDestroy' => NoteMutation::destroy($typeResolver),
            		   ];
      		}
      	]);

    }

}
