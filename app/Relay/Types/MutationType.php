<?php namespace BibleExperience\Relay\Types;

//use GraphQL\Type\Definition\EnumType;
//use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;

use BibleExperience\Relay\Types\UserType AS User;
use BibleExperience\Relay\Types\CourseType AS Course;
use BibleExperience\Relay\Types\LessonType AS Lesson;
use BibleExperience\Relay\Types\LessonNoteType AS LessonNote;

use BibleExperience\User as UserModel;
use BibleExperience\Course as CourseModel;
use BibleExperience\Lesson as LessonModel;
use BibleExperience\LessonNote as LessonNoteModel;

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

	$lessonNoteUpdateMutation = Relay::mutationWithClientMutationId([
	    'name' => 'LessonNoteUpdate',
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
		'lessonNote' => [
		    'type' => $typeResolver->get(LessonNote::class),
		    'resolve' => function ($payload) {
		        return $payload['lessonNote'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$input['id'] =  $this->decodeGlobalId($input['id'])['id'];
		$new = LessonNoteModel::updateFromArray($input);
		return [
		    'error' => $new['error'],
		    'code' => $new['code'],
 		    'lessonNote' => $new['lessonNote'],
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

	$lessonNoteCreateMutation = Relay::mutationWithClientMutationId([
	    'name' => 'LessonNoteCreate',
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
		'lessonnote' => [
		    'type' => $typeResolver->get(LessonNote::class),
		    'resolve' => function ($payload) {
		        return $payload['lessonnote'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {
		$input['note_id'] =  $this->decodeGlobalId($input['note_id'])['id'];
		$input['lesson_id'] =  $this->decodeGlobalId($input['lesson_id'])['id'];
		$new = LessonNoteModel::createFromArray($input);
		return [
		    'error' => $new['error'],
		    'code' => $new['code'],
 		    'lessonnote' => $new['lessonnote'],
		];
	    }
	]);

	$lessonNoteDestroyMutation = Relay::mutationWithClientMutationId([
	    'name' => 'LessonNoteDestroy',
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
		'destroyedLessonNoteID' => [
		    'type' => Type::string(),
		    'resolve' => function ($payload) {
		        return $payload['destroyed_lessonnote_id'];
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
		$lessonnote = LessonNoteModel::find($id);
		$lesson = $lessonnote->lesson;
		$note = LessonNoteModel::destroyFromRelay($id);
		
		return [
		    'error' => $note['error'],
		    'code' => $note['code'],
 		    'lesson' => $lesson,
		    'destroyed_lessonnote_id' => $input['id']
		];
	    }
	]);

        return parent::__construct([
            'name' => 'Mutation',
                'fields' => function () use ($loginMutation, $updateCourseMutation, $lessonUpdateMutation, $lessonNoteUpdateMutation, $lessonCreateMutation, $lessonNoteCreateMutation, $lessonNoteDestroyMutation) {
		   return [
		    'loginUser' => $loginMutation,
		    'courseUpdate' => $updateCourseMutation,
		    'lessonUpdate' => $lessonUpdateMutation,
		    'lessonNoteUpdate' => $lessonNoteUpdateMutation,
		    'lessonCreate' => $lessonCreateMutation,
		    'lessonNoteCreate' => $lessonNoteCreateMutation,
		    'lessonNoteDestroy' => $lessonNoteDestroyMutation
		   ];
		}
	]);

    }

}

