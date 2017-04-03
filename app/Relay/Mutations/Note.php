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

class Note {

    public static function create(TypeResolver $typeResolver){
      return Relay::mutationWithClientMutationId([
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
    		    'type' => $typeResolver->get(NoteType::class),
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
        'type' => $typeResolver->get(NoteType::class),
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
}

}
