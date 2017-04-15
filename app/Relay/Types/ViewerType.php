<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\BibleType;
use BibleExperience\Relay\Types\BibleBookType;
use BibleExperience\Relay\Types\BibleChapterType;
use BibleExperience\Relay\Types\BibleVerseType;
use BibleExperience\Relay\Types\BibleVersionType;
use BibleExperience\Relay\Types\CourseType;
use BibleExperience\Relay\Types\CrossReferenceType;
use BibleExperience\Relay\Types\LibraryType;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\Relay\Types\StepType;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\ErrorType;

use BibleExperience\Course;
use BibleExperience\Note;
use BibleExperience\User;
use BibleExperience\Viewer;

class ViewerType extends ObjectType {

  use GlobalIdTrait;

  public function __construct(TypeResolver $typeResolver)
    {

   $defaultArgs = GraphQLGenerator::defaultArgs();
   $simpleArgs = GraphQLGenerator::simpleArgs();

   $biblesConnectionType = GraphQLGenerator::connectionType($typeResolver, BibleType::class);
	 $bibleBooksConnectionType = GraphQLGenerator::connectionType($typeResolver, BibleBookType::class);
	 $bibleChaptersConnectionType = GraphQLGenerator::connectionType($typeResolver, BibleChapterType::class);
	 $bibleVersesConnectionType = GraphQLGenerator::connectionType($typeResolver, BibleVerseType::class);

   $crossReferencesConnectionType = GraphQLGenerator::connectionType($typeResolver, CrossReferenceType::class);
	 $librariesConnectionType = GraphQLGenerator::connectionType($typeResolver, LibraryType::class);
	 $coursesConnectionType = GraphQLGenerator::connectionType($typeResolver, CourseType::class);
	 $lessonsConnectionType = GraphQLGenerator::connectionType($typeResolver, LessonType::class);
	 $stepsConnectionType = GraphQLGenerator::connectionType($typeResolver, StepType::class);
	 $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);

        return parent::__construct([
            'name' => 'Viewer',
            'description' => '',
            'fields' => [
              'error' => ['type' =>  $typeResolver->get(ErrorType::class)],
               'user' => [
                    'type' =>  $typeResolver->get(UserType::class),
                    'args' => [],
                    'resolve' => function($root, $args, $resolveInfo){return $root->user;}
               ],
              'notes' => [
                    'type' => $typeResolver->get($notesConnectionType),
                    'description' => 'Notes Application Wide.',
                    'args' => array_merge(Relay::connectionArgs(), ['filter' => ['type' => Type::string()], 'id' => ['type' => Type::string()], 'user' => ['type' => Type::boolean()] ]),
                    'resolve' => function($root, $args, $resolveInfo){
                        return $this->paginatedConnection($root->notes($args, false), $args);
	                  },
              ],
              'note' => [
                  'type' =>  $typeResolver->get(NoteType::class),
		              'description' => 'Note that matches Id.',
                  'args' => $simpleArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                 return Note::find($this->decodeRelayId($args['id']));
			       },
              ],
              'libraries' => [
                  'type' =>   $typeResolver->get($librariesConnectionType),
		              'description' => 'Libraries Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
	                return $this->paginatedConnection($root->libraries($args, false), $args);
	            },
              ],
              'courses' => [
                  'type' =>  $typeResolver->get($coursesConnectionType),
		              'description' => 'Courses Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			         return $this->paginatedConnection($root->courses($args, false), $args);
			       },
              ],
              'course' => [
                  'type' =>  $typeResolver->get(CourseType::class),
		              'description' => 'Course that matches Id.',
                  'args' => $simpleArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                 return Course::find($this->decodeRelayId($args['id']));
			       },
              ],
              'bibles' => [
                  'type' =>  $typeResolver->get($biblesConnectionType),
                  'description' => 'Bibles Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args,$resolveInfo){
                  return $this->paginatedConnection($root->bibles($args, false), $args);
              },
              ],
              'bibleBooks' => [
                  'type' =>  $typeResolver->get($bibleBooksConnectionType),
		              'description' => 'Bible Books Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                return $this->paginatedConnection($root->bibleBooks($args, false), $args);
			            },
              ],
              'bibleChapters' => [
                  'type' =>  $typeResolver->get($bibleChaptersConnectionType),
		              'description' => 'Bible Chapters Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                return $this->paginatedConnection($root->bibleChapters($args, false), $args);
			            },
              ],
              'bibleChapter' => [
                  'type' =>  $typeResolver->get(BibleChapterType::class),
		              'description' => 'a Bible Chapter.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                return $root->bibleChapter($args, false);
			            },
              ],
              'bibleVerses' => [
                  'type' =>  $typeResolver->get($bibleVersesConnectionType),
		              'description' => 'Bible Verses Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                return $this->paginatedConnection($root->bibleVerses($args, false), $args);
			            },
              ],

              'bibleVerse' => [
                  'type' =>  $typeResolver->get(BibleVerseType::class),
		              'description' => 'a Bible Verse.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                return $root->bibleVerse($args, false);
			            },
              ],
              'crossReferences' => [
                  'type' =>  $typeResolver->get($crossReferencesConnectionType),
                  'description' => 'Bible Verses Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
                      return $this->paginatedConnection($root->crossReferences($args, false), $args);
                  },
              ],
              'lessons' => [
                  'type' =>  $typeResolver->get($lessonsConnectionType),
		              'description' => 'Lessons Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                return $this->paginatedConnection($root->lessons($args, false), $args);
			            },
              ],
              'steps' => [
                  'type' => $typeResolver->get($stepsConnectionType),
		              'description' => 'Steps Application Wide.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
			                return $this->paginatedConnection($root->steps($args, false), $args);
			            },
              ],
          ],
           'interfaces' => []
        ]);
    }

}
