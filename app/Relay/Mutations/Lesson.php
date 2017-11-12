<?php namespace BibleExperience\Relay\Mutations;

//use GraphQL\Type\Definition\EnumType;
//use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;

use BibleExperience\Relay\Types\UserCourseType;
use BibleExperience\Relay\Types\UserLessonType;

use BibleExperience\Lesson as LessonModel;
use BibleExperience\User as UserModel;

class Lesson {

    public static function create(TypeResolver $typeResolver){
      return Relay::mutationWithClientMutationId([
    	    'name' => 'LessonCreate',
    	    'inputFields' => [
                'token' => [
                    'type' => Type::string(),
                ],
        		'title' => [
        		    'type' => Type::string()
        		],
        		'description' => [
        		    'type' =>  Type::string()
        		],
        		'course_id' => [
        		    'type' =>  Type::nonNull(Type::string())
        		],   
                'body' => [
                    'type' =>  Type::string()
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
    		'course' => [
    		    'type' => $typeResolver->get(UserCourseType::class),
    		    'resolve' => function ($payload) {
    		        return $payload['course'];
    		    }
    		]
    	    ],
    	    'mutateAndGetPayload' => function ($input) {
    		
            $input['course_id'] = Relay::fromGlobalId($input['course_id'])['id'];

            $user = UserModel::getAuth($input['token']);

            $userCan = $user->user->can('CREATE_LESSON', $input);
           

            if($userCan->can){
                $new = LessonModel::createFromArray(array_except($input,['token','clientMutationId']));
                $new['course'] = $new['lesson']->course;
            }else{
                $new['error'] = $userCan->reason;
                $new['code'] = 500;
                $new['course'] = CourseModel::find($input['course_id']);;
            }

    		

    		return [
    		    'error' => $new['error'],
    		    'code' => $new['code'],
     		    'course' => $new['course'],
    		];
    	    }
    	]);


    }

    public static function destroy(TypeResolver $typeResolver){

        return  Relay::mutationWithClientMutationId([
        'name' => 'LessonDestroy',
        'inputFields' => [
            'id' => [
                'type' => Type::nonNull(Type::string())
            ],
            'token' => [
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
        'lesson' => [
            'type' => $typeResolver->get(UserLessonType::class),
            'resolve' => function ($payload) {
                return $payload['lesson'];
            }
        ]
        ],
        'mutateAndGetPayload' => function ($input) {

            $input['id'] =  Relay::fromGlobalId($input['id'])['id'];

            $user = UserModel::getAuth($input['token']);

            $userCan = $user->user->can('DESTROY_LESSON', $input);

            if($userCan->can){
                $new = LessonModel::find($input['id']);
                $new->bodies()->delete();
                $new->delete();
            }else{
                $new['error'] = $userCan->reason;
                $new['code'] = 500;
                $new['lesson'] = $new;
            }

            return [
                'error' => $new['error'],
                'code' => $new['code'],
                'lesson' => $new['lesson'],
            ];

        return [
            'error' => $new['error'],
            'code' => $new['code'],
            'lesson' => $new['lesson'],
        ];
        }
    ]);
    }

public static function update(TypeResolver $typeResolver){

  return  Relay::mutationWithClientMutationId([
	    'name' => 'LessonUpdate',
	    'inputFields' => [
		'id' => [
		    'type' => Type::nonNull(Type::string())
		],
            'token' => [
                'type' =>  Type::string()
            ],
		'title' => [
		    'type' => Type::string()
		],
		'description' => [
		    'type' =>  Type::string()
		],
		'course_id' => [
		    'type' =>  Type::int()
		],  
            'body' => [
                'type' =>  Type::string()
            ],
		'order_by' => [
		    'type' =>  Type::int()
		],
        'body_id' => [
            'type' =>  Type::int()
        ],
        'body' => [
            'type' =>  Type::string()
        ],

        //TGVzc29uOjI1
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
		    'type' => $typeResolver->get(UserLessonType::class),
		    'resolve' => function ($payload) {
		        return $payload['lesson'];
		    }
		]
	    ],
	    'mutateAndGetPayload' => function ($input) {

		    $input['id'] =  Relay::fromGlobalId($input['id'])['id'];

            $user = UserModel::getAuth($input['token']);

            $userCan = $user->user->can('UPDATE_LESSON', $input);

            if($userCan->can){
                $new = LessonModel::updateFromArray($input);
            }else{
                $new['error'] = $userCan->reason;
                $new['code'] = 500;
                $new['lesson'] = new LessonModel;
            }

            return [
                'error' => $new['error'],
                'code' => $new['code'],
                'lesson' => $new['lesson'],
            ];

		return [
		    'error' => $new['error'],
		    'code' => $new['code'],
 		    'lesson' => $new['lesson'],
		];
	    }
	]);

}

}
