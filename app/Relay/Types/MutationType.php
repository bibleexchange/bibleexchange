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

use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\User as UserModel;
use BibleExperience\Course as CourseModel;
use BibleExperience\Lesson as LessonModel;
use BibleExperience\Step as StepModel;
use BibleExperience\Note as NoteModel;

class MutationType extends ObjectType {

use GlobalIdTrait;

    public function __construct(TypeResolver $typeResolver)
    {

	$loginMutation = Relay::mutationWithClientMutationId([
	    'name' => 'LoginUser',
	    'inputFields' => [
		'email' => [
		    'type' => Type::nonNull(Type::string())
		],
		'password' => [
		    'type' =>  Type::nonNull(Type::string())
		]
	    ],
	    'outputFields' => [
		'token' => [
		    'type' => Type::string(),
		    'resolve' => function ($payload) {
		        return $payload['token'];
		    }
		],
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
		'user' => [
		    'type' => $typeResolver->get(User::class),
		    'resolve' => function ($payload) {
		        return $payload['user'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$newAuth = UserModel::login($input['email'], $input['password']);
		return [
		    'token' => $newAuth['token'],
		    'error' => $newAuth['error'],
		    'code' => $newAuth['code'],
 		    'user' => $newAuth['user'],
		];
	    }
	]);

	$signUpUserMutation = Relay::mutationWithClientMutationId([
	    'name' => 'SignUpUser',
	    'inputFields' => [
		'email' => [
		    'type' => Type::nonNull(Type::string())
		],
		'password' => [
		    'type' =>  Type::nonNull(Type::string())
		]
	    ],
	    'outputFields' => [
		'token' => [
		    'type' => Type::string(),
		    'resolve' => function ($payload) {
		        return $payload['token'];
		    }
		],
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
		'user' => [
		    'type' => $typeResolver->get(User::class),
		    'resolve' => function ($payload) {
		        return $payload['user'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$newAuth = UserModel::signup($input['email'], $input['password']);
		return [
		    'token' => $newAuth['token'],
		    'error' => $newAuth['error'],
		    'code' => $newAuth['code'],
 		    'user' => $newAuth['user'],
		];
	    }
	]);

	$updateCourseMutation = Relay::mutationWithClientMutationId([
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
		    'type' => $typeResolver->get(Course::class),
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


	$lessonUpdateMutation = Relay::mutationWithClientMutationId([
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
		    'type' => $typeResolver->get(Lesson::class),
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

	$stepUpdateMutation = Relay::mutationWithClientMutationId([
	    'name' => 'StepUpdate',
	    'inputFields' => [
		'id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'lesson_id' => [
		    'type' => Type::string()
		],
		'note_id' => [
		    'type' => Type::string()
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
		'step' => [
		    'type' => $typeResolver->get(Step::class),
		    'resolve' => function ($payload) {
		        return $payload['step'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$input['id'] =  $this->decodeGlobalId($input['id'])['id'];
		$new = StepModel::updateFromArray($input);
		return [
		    'error' => $new['error'],
		    'code' => $new['code'],
 		    'step' => $new['step'],
		];
	    }
	]);

	$updateCourseMutation = Relay::mutationWithClientMutationId([
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
		    'type' => $typeResolver->get(Course::class),
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


	$lessonCreateMutation = Relay::mutationWithClientMutationId([
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
		    'type' => $typeResolver->get(Lesson::class),
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

	$stepCreateMutation = Relay::mutationWithClientMutationId([
	    'name' => 'StepCreate',
	    'inputFields' => [
		'id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'note_id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'lesson_id' => [
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
		'step' => [
		    'type' => $typeResolver->get(Step::class),
		    'resolve' => function ($payload) {
		        return $payload['step'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$input['note_id'] =  $this->decodeGlobalId($input['note_id'])['id'];
		$input['lesson_id'] =  $this->decodeGlobalId($input['lesson_id'])['id'];
		$new = StepModel::createFromArray($input);
		return [
		    'error' => $new['error'],
		    'code' => $new['code'],
 		    'step' => $new['step'],
		];
	    }
	]);

	$stepDestroyMutation = Relay::mutationWithClientMutationId([
	    'name' => 'StepDestroy',
	    'inputFields' => [
		'id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'note_id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'lesson_id' => [
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
		'destroyedStepID' => [
		    'type' => Type::string(),
		    'resolve' => function ($payload) {
		        return $payload['destroyed_step_id'];
		    }
		],
		'lesson' => [
		    'type' => $typeResolver->get(Lesson::class),
		    'resolve' => function ($payload) {
		        return $payload['lesson'];
		    }
		]
	    ],
    	'mutateAndGetPayload' => function ($input) {
    		$id =  $this->decodeGlobalId($input['id'])['id'];
    		$step = StepModel::find($id);
    		$lesson = $step->lesson;
    		$note = StepModel::destroyFromRelay($id);

    		return [
    		    'error' => $note['error'],
    		    'code' => $note['code'],
     		    'lesson' => $lesson,
    		    'destroyed_step_id' => $input['id']
    		];
	    }
	]);

	$noteCreateMutation = Relay::mutationWithClientMutationId([
	    'name' => 'NoteCreate',
	    'inputFields' => [
		'id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'bible_verse_id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'type' => [
		    'type' => Type::nonNull(Type::string())
		],
		'body' => [
		    'type' =>  Type::nonNull(Type::string())
		],
		'tags_string' => [
		    'type' =>  Type::string()
		],
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
		'note' => [
		    'type' => $typeResolver->get(Note::class),
		    'resolve' => function ($payload) {
		        return $payload['note'];
		    }
		],
		'bibleVerse' => [
		    'type' => $typeResolver->get(BibleVerse::class),
		    'resolve' => function ($payload) {
		        return $payload['bible_verse'];
		    }
		],
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$input['bible_verse_id'] =  $this->decodeGlobalId($input['bible_verse_id'])['id'];
		$user = \JWTAuth::parseToken()->authenticate();
		$new = NoteModel::createFromRelay($input['type'], $input['body'], $input['bible_verse_id'], $user, $input['tags_string']);
		return [
		    'error' => $new['error'],
		    'code' => $new['code'],
 		    'note' => $new['note'],
		    'bible_verse' => BibleVerseModel::find($input['bible_verse_id'])
		];
	    }
	]);

	$noteUpdateMutation = Relay::mutationWithClientMutationId([
	    'name' => 'NoteUpdate',
	    'inputFields' => [
		'id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'bible_verse_id' => [
		    'type' => Type::nonNull(Type::string())
		],
		'type' => [
		    'type' => Type::nonNull(Type::string())
		],
		'body' => [
		    'type' =>  Type::nonNull(Type::string())
		],
		'tags_string' => [
		    'type' =>  Type::string()
		],
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
		'note' => [
		    'type' => $typeResolver->get(Note::class),
		    'resolve' => function ($payload) {
		        return $payload['note'];
		    }
		],
		'bibleVerse' => [
		    'type' => $typeResolver->get(BibleVerse::class),
		    'resolve' => function ($payload) {
		        return $payload['bible_verse'];
		    }
		],
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$input['bible_verse_id'] =  $this->decodeGlobalId($input['bible_verse_id'])['id'];
		$input['id'] =  $this->decodeGlobalId($input['id'])['id'];
		$user = \JWTAuth::parseToken()->authenticate();
		$new = NoteModel::updateFromArray($input, $user);

		return [
		    'error' => $new['error'],
		    'code' => $new['code'],
 		    'note' => $new['note'],
		    'bible_verse' => BibleVerseModel::find($input['bible_verse_id'])
		];
	    }
	]);

	$noteDestroyMutation = Relay::mutationWithClientMutationId([
	    'name' => 'NoteDestroy',
	    'inputFields' => [
		'id' => [
		    'type' => Type::nonNull(Type::string())
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
		'destroyedNoteID' => [
		    'type' => Type::string(),
		    'resolve' => function ($payload) {
		        return $payload['destroyed_note_id'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$id =  $this->decodeGlobalId($input['id'])['id'];
		$note = NoteModel::destroyFromRelay($id);

		return [
		    'error' => $note['error'],
		    'code' => $note['code'],
		    'destroyed_note_id' => $input['id']
		];
	    }
	]);
        return parent::__construct([
            'name' => 'Mutation',
                'fields' => function () use ($loginMutation, $updateCourseMutation, $lessonUpdateMutation, $stepUpdateMutation, $lessonCreateMutation, $stepCreateMutation, $stepDestroyMutation, $signUpUserMutation, $noteCreateMutation, $noteUpdateMutation, $noteDestroyMutation) {
            		   return [
            		    'loginUser' => $loginMutation,
            		    'courseUpdate' => $updateCourseMutation,
            		    'lessonUpdate' => $lessonUpdateMutation,
            		    'stepUpdate' => $stepUpdateMutation,
            		    'lessonCreate' => $lessonCreateMutation,
            		    'stepCreate' => $stepCreateMutation,
            		    'stepDestroy' => $stepDestroyMutation,
            		    'signUpUser' => $signUpUserMutation,
            		    'noteCreate' => $noteCreateMutation,
            		    'noteUpdate' => $noteUpdateMutation,
            		    'noteDestroy' => $noteDestroyMutation,
            		   ];
      		}
      	]);

    }

}
