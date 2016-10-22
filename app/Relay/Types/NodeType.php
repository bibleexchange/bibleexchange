<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Models\StarWarsData;

use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

use BibleExperience\Relay\Types\BibleType as Bible;
use BibleExperience\Relay\Types\BibleVersionType as BibleVersion;
use BibleExperience\Relay\Types\BibleBookType as BibleBook;
use BibleExperience\Relay\Types\BibleChapterType as BibleChapter;
use BibleExperience\Relay\Types\BibleVerseType as BibleVerse;
use BibleExperience\Relay\Types\LibraryType as Library;
use BibleExperience\Relay\Types\CourseType as Course;
use BibleExperience\Relay\Types\LessonType as Lesson;
use BibleExperience\Relay\Types\StepType as Step;
use BibleExperience\Relay\Types\NoteType as Note;
use BibleExperience\Relay\Types\UserType as User;
use BibleExperience\Relay\Types\ViewerType as Viewer;

class NodeType extends InterfaceType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

      $this->classnames = [
            'Bible'=> Bible::class,
            'BibleBook'=> BibleBook::class,
            'BibleChapter'=> BibleChapter::class,
            'BibleVerse'=> BibleVerse::class,
            'Library'=> Library::class,
            'Course'=> Course::class,
            'Lesson'=> Lesson::class,
            'Step'=> Step::class,
            'Note'=> Note::class,
            'User'=> User::class,
            'Viewer'=> Viewer::class,
          ];

      return parent::__construct([
          'name' => 'Node',
          'description' => 'An object with an ID',
          'fields' => [
              'id' => [
                  'type' => Type::nonNull(Type::id()),
                  'description' => 'The id of the object',
              ]
          ],
          'resolveType' => function($obj) use (&$typeResolver){
              return $typeResolver->get($this->classnames[$obj->relayType]);
          }
      ]);
    }
}
