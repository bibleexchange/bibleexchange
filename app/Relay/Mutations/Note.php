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

      return Relay::mutationWithClientMutationId([
    	    'name' => 'NoteCreate',
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
    		    'type' =>  
                Type::nonNull(Type::string())
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
    		'newNoteEdge' => [
    		    'type' => $typeResolver->get($noteEdgeType),
                'description' => 'The books of the Bible.',
                'args' => GraphQLGenerator::defaultArgs(),
    		    'resolve' => function ($payload, $args, $resolveInfo) {
    		        return $payload['newNoteEdge'];
    		    }
    		],
            'user' => [
                'type' => $typeResolver->get(UserType::class),
                'resolve' => function ($payload) {
                    return $payload['user'];
                }
            ]
    	    ],
    	    'mutateAndGetPayload' => function ($input) {
    		$user = \JWTAuth::parseToken()->authenticate();
           //$user = UserModel::find(1);
    		$new = NoteModel::createFromRelay( $input, $user);
            $note = new stdClass();
            $note->cursor = base64_encode('arrayconnection:100000000');
            $note->node = $new['note'];

    		return [
    		    'error' => $new['error'],
    		    'code' => $new['code'],
     		    'newNoteEdge' => $note,
                'user' => $user
    		];
    	    }
    	]);

    }

    public static function destroy(TypeResolver $typeResolver){

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
    'bibleVerse' => [
        'type' => $typeResolver->get(BibleVerseType::class),
        'resolve' => function ($payload) {
            return $payload['bible_verse'];
        }
    ],
      ],
      'mutateAndGetPayload' => function ($input) {
    
        $input['id'] =  Relay::fromGlobalId($input['id'])['id'];

        $user = \JWTAuth::parseToken()->authenticate();
        $new = NoteModel::updateFromArray($input, $user);

        return [
            'error' => $new['error'],
            'code' => $new['code'],
            'note' => $new['note'],
            'bible_verse' => BibleVerseModel::findByReference($input['reference'])
        ];
      }
  ]);
}

}