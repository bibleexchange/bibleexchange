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

use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\Course as CourseModel;
use BibleExperience\Lesson as LessonModel;
use BibleExperience\Step as StepModel;
use BibleExperience\Note as NoteModel;
use BibleExperience\User as UserModel;

use stdClass;

class Note {

    public static function create(TypeResolver $typeResolver){


    $noteEdgeType = GraphQLGenerator::edgeType($typeResolver, NoteType::class);
     $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);

      return Relay::mutationWithClientMutationId([
    	    'name' => 'NoteCreate',
    	    'inputFields' => [
        		'id' => [
        		    'type' => Type::string()
        		],
        		'bible_verse_id' => [
        		    'type' => Type::string()
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
            'token' => [
                'type' => Type::string(),
                'resolve' => function ($payload) {
                    return $payload['token'];
                }
            ],
    		'newNoteEdge' => [
    		    'type' => $typeResolver->get($noteEdgeType),
                'description' => 'The Note the User just created',
                'args' => GraphQLGenerator::defaultArgs(),
    		    'resolve' => function ($payload, $args, $resolveInfo) {
    		        return $payload['newNoteEdge'];
    		    }
    		],
            'myNotes' => [
                'type' => $typeResolver->get($notesConnectionType),
                'resolve' => function ($payload) {
                    return $payload['myNotes'];
                }
            ]
    	    ],
    	    'mutateAndGetPayload' => function ($input) {
    		$auth = UserModel::getAuth($input['token']);
            $user = $auth->user;
           //$user = UserModel::find(1);
    		$new = NoteModel::createFromBody($input, $user);
            $note = new stdClass();
            $note->cursor = base64_encode('arrayconnection:5');
            $note->node = $new['note'];

            if($auth->error->code === 200){
                $errorMessage = $new['error'];
                $errorCode = $new['code'];
            }else{
                $errorMessage = $auth->error->message;
                $errorCode = $auth->error->code;
            }

    		return [
    		    'error' => $errorMessage,
    		    'code' => $errorCode,
     		    'newNoteEdge' => $note,
                'myNotes' => $auth->myNotes,
                'token' => $auth->token
    		];
    	    }
    	]);

    }

    public static function destroy(TypeResolver $typeResolver){

             $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);

      return Relay::mutationWithClientMutationId([
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
        ],
        'token' => [
            'type' =>  Type::nonNull(Type::string())
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

    }

public static function update(TypeResolver $typeResolver){

     $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);

  return Relay::mutationWithClientMutationId([
      'name' => 'NoteUpdate',
      'inputFields' => [
    'id' => [
        'type' => Type::nonNull(Type::string())
    ],
    'bible_verse_id' => [
        'type' => Type::string()
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
    'title' => [
        'type' =>  Type::string()
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
        'type' => $typeResolver->get(NoteType::class),
        'resolve' => function ($payload) {
            return $payload['note'];
        }
    ],
    'myNotes' => [
        'type' => $typeResolver->get($notesConnectionType),
        'resolve' => function ($payload) {
            return $payload['myNotes'];
        }
    ]
      ],
      'mutateAndGetPayload' => function ($input) {
    
        $input['id'] =  Relay::fromGlobalId($input['id'])['id'];
        $auth = UserModel::getAuth($input['token']);
        $new = NoteModel::updateFromBody($input, $auth->user);

        return [
            'error' => $new['error'],
            'code' => $new['code'],
            'note' => $new['note'],
            'myNotes' => $auth->myNotes
        ];
      }
  ]);
}

}