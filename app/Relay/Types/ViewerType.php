<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

use BibleExperience\Relay\Types\NodeType AS Node;
use BibleExperience\Relay\Types\BibleType AS Bible;
use BibleExperience\Relay\Types\BibleBookType AS BibleBook;
use BibleExperience\Relay\Types\BibleChapterType AS BibleChapter;
use BibleExperience\Relay\Types\BibleVerseType AS BibleVerse;
use BibleExperience\Relay\Types\BibleVersionType AS BibleVersion;
use BibleExperience\Relay\Types\CourseType AS Course;
use BibleExperience\Relay\Types\LibraryType AS Library;
use BibleExperience\Relay\Types\NoteType AS Note;
use BibleExperience\Relay\Types\LessonNoteType AS LessonNote;
use BibleExperience\Relay\Types\UserType AS User;

use BibleExperience\User AS UserModel;
use BibleExperience\Bible AS BibleModel;
use BibleExperience\BibleChapter AS BibleChapterModel;
use BibleExperience\BibleVerse AS BibleVerseModel;
use BibleExperience\LessonNote AS LessonNoteModel;
use BibleExperience\Note AS NoteModel;
use BibleExperience\Course AS CourseModel;
use BibleExperience\Library AS LibraryModel;

class ViewerType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

	$libraryConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(Library::class)]);
  $libraryArgs =   [
          'find' => [
              'description' => '',
              'type' => Type::string()
            ]
    ];

$notesConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(Note::class)]);
  $noteArgs =   [
          'filter' => [
              'description' => '',
              'type' => Type::string()
            ]
    ];

        return parent::__construct([
            'name' => 'Viewer',
            'description' => '',
            'fields' => [
                'user' => [
                    'type' =>  $typeResolver->get(User::class),
                    'args' => [],
                    'resolve' => function($root, $args, $resolveInfo){
            		return $root;
            	    }
            ],
              'bible' => [
                  'type' => $typeResolver->get(Bible::class),
                  'args' => [
                      'version' => [
                          'description' => 'If omitted, returns KJV. If provided, returns the version of that particular Bible.',
                          'type' => $typeResolver->get(BibleVersion::class),
                      ]
                  ],
                  'resolve' => function ($root, $args) {
                      return BibleModel::getVersion(isset($args['version']) ? $args['version'] : null);
                  },
              ],
              'libraries' => [
                    'type' =>  $libraryConnection['connectionType'],
                    'description' => 'Libraries.',
                    'args' => array_merge(Relay::connectionArgs(), $libraryArgs),
                    'resolve' => function($root, $args, $resolveInfo){
                        if(isset($args['find'])){
                          return LibraryModel::find($args['find']);
                        }else {
                          return $this->paginatedConnection(LibraryModel::all(), $args);
                        }
                  },
              ],
              'library' => [
                    'type' =>  $typeResolver->get(Library::class),
                    'description' => 'Libraries.',
                    'args' => $libraryArgs,
                    'resolve' => function($root, $args, $resolveInfo){
                        if(isset($args['find'])){
                          return LibraryModel::find($args['find']);
                        }
                  },
              ],
              'bibleChapter' => [
                  'type' => $typeResolver->get(BibleChapter::class),
                  'args' => [
                      'id' => [
                          'name' => 'id',
                          'description' => 'id of the bible chapter.',
                          'type' => Type::string()
                      ],
                      'reference' => [
                            'name' => 'reference',
                            'description' => 'reference of the bible chapter.',
                            'type' => Type::string()
                      ]
                  ],
                  'resolve' => function ($root, $args){

                      if(isset($args['id'])){
                        $decoded = $this->decodeGlobalId($args['id']);

                        if(is_array($decoded) && count($decoded) > 1){
                          return BibleChapterModel::find($decoded['id']);
                        }else{
                          return BibleChapterModel::find($args['id']);
                        }


                      } else {
                        return BibleChapterModel::findByReference($args['reference']);
                      }
                  },
              ],
              'bibleVerse' => [
                  'type' => $typeResolver->get(BibleVerse::class),
                  'args' => [
                      'id' => [
                          'name' => 'id',
                          'description' => 'id of the bible verse.',
                          'type' => Type::string()
                      ],
                      'reference' => [
                            'name' => 'reference',
                            'description' => 'reference of the bible verse.',
                            'type' => Type::string()
                      ]
                  ],
                  'resolve' => function ($root, $args){

                      if(isset($args['id'])){
                        $decoded = $this->decodeGlobalId($args['id']);

                        if(is_array($decoded) && count($decoded) > 1){
                          return BibleVerseModel::find($decoded['id']);
                        }else{
                          return BibleVerseModel::find($args['id']);
                        }


                      } else {
                        return BibleVerseModel::findByReference($args['reference']);
                      }
                  },
              ],
              'course' => [
                  'type' => $typeResolver->get(Course::class),
                  'args' => [
                      'id' => [
                          'name' => 'id',
                          'description' => 'id of the course.',
                          'type' => Type::nonNull(Type::string())
                      ]
                  ],
                  'resolve' => function ($root, $args){
		     $decoded = $this->decodeGlobalId($args['id']);

                        if(is_array($decoded) && count($decoded) > 1){
                          return CourseModel::find($decoded['id']);
                        }else{
                          return CourseModel::find($args['id']);
                        }

                  }
              ],
              'note' => [
                  'type' => $typeResolver->get(Note::class),
                  'args' => [
                      'id' => [
                          'name' => 'id',
                          'description' => 'id of the note.',
                          'type' => Type::nonNull(Type::string())
                      ]
                  ],
                  'resolve' => function ($root, $args){
		     $decoded = $this->decodeGlobalId($args['id']);

                        if(is_array($decoded) && count($decoded) > 1){
                          return NoteModel::find($decoded['id']);
                        }else{
                          return NoteModel::find($args['id']);
                        }

                  },
              ],
              'lessonnote' => [
                  'type' => $typeResolver->get(LessonNote::class),
                  'args' => [
                      'id' => [
                          'name' => 'id',
                          'description' => 'id of the note.',
                          'type' => Type::nonNull(Type::string())
                      ]
                  ],
                  'resolve' => function ($root, $args){
		     $decoded = $this->decodeGlobalId($args['id']);

                        if(is_array($decoded) && count($decoded) > 1){
                          return LessonNoteModel::find($decoded['id']);
                        }else{
                          return LessonNoteModel::find($args['id']);
                        }

                  },
              ],
              'notes' => [
                    'type' =>  $typeResolver->get($notesConnection['connectionType']),
                    'description' => 'Notes Application Wide.',
                    'args' => array_merge(Relay::connectionArgs(), $noteArgs),
                    'resolve' => function($root, $args, $resolveInfo){
                        if(isset($args['filter'])){
 			  $note_collection = NoteModel::search($args['filter']);
                        }else {
			  $note_collection = NoteModel::inRandomOrder()->get();
                        }

			return $this->paginatedConnection($note_collection, $args);
                  },
              ],


          ],
           'interfaces' => []
        ]);
    }

}
