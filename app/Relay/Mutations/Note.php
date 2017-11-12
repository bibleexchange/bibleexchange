<?php namespace BibleExperience\Relay\Mutations;

//use GraphQL\Type\Definition\EnumType;
//use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\BibleVerseType;
use BibleExperience\Relay\Types\CourseType;
use BibleExperience\Relay\Types\LessonType;
use BibleExperience\Relay\Types\StepType;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\ErrorType;
use BibleExperience\Relay\Types\ViewerType;

use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\Course as CourseModel;
use BibleExperience\Lesson as LessonModel;
use BibleExperience\Step as StepModel;
use BibleExperience\Note as NoteModel;
use BibleExperience\User as UserModel;
use BibleExperience\Viewer;

use stdClass;

class Note {

    public static function create(TypeResolver $typeResolver){


    //$noteEdgeType = GraphQLGenerator::edgeType($typeResolver, NoteType::class);
     $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);

      return Relay::mutationWithClientMutationId([
    	    'name' => 'CreateNote',
    	    'inputFields' => [
        		'bible_verse_id' => [
        		    'type' => Type::string()
        		],
        		'body' => [
        		    'type' =>  Type::nonNull(Type::string())
        		],
        		'tags_string' => [
        		    'type' =>  Type::string()
        		],
                'title' => [
                    'type' =>  Type::string()
                ],
                'reference' => [
                    'type' =>  Type::string()
                ],
                 'token' => [
                    'type' =>  Type::nonNull(Type::string())
                ],
    	    ],
    	    'outputFields' => [

            'error' => [
                'type' => $typeResolver->get(ErrorType::class),
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
            'token' => [
                'type' => Type::string(),
                'resolve' => function ($payload) {
                    return $payload['token'];
                }
            ],
    		'note' => [
    		    'type' => $typeResolver->get(NoteType::class),
                'description' => 'The Note the User just created',
                'args' => GraphQLGenerator::defaultArgs(),
    		    'resolve' => function ($payload, $args, $resolveInfo) {
    		        return $payload['note'];
    		    }
    		],
            'viewer' => [
                'type' => $typeResolver->get(ViewerType::class),
                'resolve' => function ($payload) {
                    return $payload['viewer'];
                }
            ]
    	    ],
    	    'mutateAndGetPayload' => function ($input) {
    		$auth = UserModel::getAuth($input['token']);
    		$new = NoteModel::createFromRelay($input, $auth->user);

    		return [
    		    'error' => $new->error,
     		    'note' => $new->note,
                'viewer' => new Viewer($auth),
                'token' => $auth->token
    		];
    	    }
    	]);

    }

    public static function delete(TypeResolver $typeResolver){

             $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);

      return Relay::mutationWithClientMutationId([
          'name' => 'DeleteNote',
          'inputFields' => [
        'id' => [
            'type' => Type::nonNull(Type::string())
        ]
          ],
          'outputFields' => [

            'error' => [
                'type' => $typeResolver->get(ErrorType::class),
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
        'deletedId' => [
            'type' => Type::string(),
            'resolve' => function ($payload) {
                return $payload['destroyed_note_id'];
            }
        ],
        'token' => [
            'type' =>  Type::nonNull(Type::string())
        ]
          ],
          'mutateAndGetPayload' => function ($input) {
        $id =  Relay::fromGlobalId($input['id'])['id'];
        $note = NoteModel::destroyFromRelay($id);

        return [
            'error' => $note['error'],
            'code' => $note['code'],
            'destroyed_note_id' => $input['id']
        ];
          }
      ]);

    }

public static function update(TypeResolver $typeResolver){

     $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);

  return Relay::mutationWithClientMutationId([
      'name' => 'UpdateNote',
      'inputFields' => [
            'id' => [
                'type' => Type::nonNull(Type::string())
            ], 
            'title' => [
                'type' =>  Type::string()
            ],
            'tags_string' => [
                'type' =>  Type::string()
            ],
            'body' => [
                'type' =>  Type::nonNull(Type::string())
            ],
            'reference' => [
                'type' =>  Type::string()
            ],
             'token' => [
                'type' =>  Type::nonNull(Type::string())
            ]
      ],
      'outputFields' => [

    'error' => [
        'type' => $typeResolver->get(ErrorType::class),
        'resolve' => function ($payload) {
            return $payload['error'];
        }
    ],
    'note' => [
        'type' => $typeResolver->get(NoteType::class),
        'resolve' => function ($payload) {
            return $payload['note'];
        }
    ],
    'viewer' => [
        'type' => $typeResolver->get($notesConnectionType),
        'resolve' => function ($payload) {
            return $payload['viewer'];
        }
    ]
      ],
      'mutateAndGetPayload' => function ($input) {
    
        $input['id'] =  Relay::fromGlobalId($input['id'])['id'];
        $auth = UserModel::getAuth($input['token']);
        $new = NoteModel::updateFromArray($input, $auth->user);

        return [
            'error' => $new['error'],
            'note' => $new['note'],
            'viewer' => new Viewer($auth)
        ];
      }
  ]);
}

}