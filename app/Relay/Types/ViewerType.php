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
use BibleExperience\Relay\Types\ResourceType;
use BibleExperience\Relay\Types\StepType;
use BibleExperience\Relay\Types\TrackType;
use BibleExperience\Relay\Types\UserTrackType;
use BibleExperience\Relay\Types\NavHistoryType as NavigationType;

use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\UserCourseType;
use BibleExperience\Relay\Types\UserNoteType;
use BibleExperience\Relay\Types\UserLessonType;

use BibleExperience\Relay\Types\ErrorType;
use BibleExperience\Relay\Types\SimpleNoteType;
use BibleExperience\Relay\Types\SearchType;

use BibleExperience\Bible;
use BibleExperience\BibleBook;
use BibleExperience\BibleChapter;
use BibleExperience\BibleVerse;
use BibleExperience\Library;
use BibleExperience\Course;
use BibleExperience\CrossReference;
use BibleExperience\Lesson;
use BibleExperience\Resource;
use BibleExperience\Step;
use BibleExperience\Note;
use BibleExperience\Search;
use BibleExperience\Track;
use BibleExperience\User;
use BibleExperience\Viewer;

use ArrayObject;

class FakeBibleChapter extends ArrayObject {

  public function __construct($id, $verses){
    $this->id = $id;
    $this->verses = $verses;
    $this->notes = collect([]);
  }

  public function verses(){
    return $this->verses;
  }

    public function notes(){
    return $this->notes;
  }

  public function orderBy(){
    return $this;
  }

  public function id(){
    return $this->id;
  }
}

class OneAndMany {

    public static function many($typeResolver, $model){
       return [
                    'type' => GraphQLGenerator::resolveConnectionType($typeResolver, $model[2]),
                    'description' => 'A Collection of ' . ucfirst($model[1]) . ' on Bible exchange.',
                    'args' => GraphQLGenerator::paginationArgs(),
                    'resolve' => function($root, $args, $resolveInfo) use ($model){
                        return $root->many($args,$model);
                    },
              ];
    }

    public static function one($typeResolver, $model){
       return [
            'type' => $typeResolver->get( $model[2]),
            'description' => ucfirst($model[0]) . ' on Bible exchange.',
            'args' => GraphQLGenerator::defaultArgs(),
            'resolve' => function($root, $args, $resolveInfo) use ($model){

                

                 if($model[0] !== "bibleChapter") {
                    return $root->one($args,$model);
                  }else{

                    $chapter = $root->one($args,$model);

                    if($chapter !== null){
                      return $chapter;
                    }else{
                      $verses = BibleVerse::where('body','LIKE','%'.$args['id'].'%');
                      $chapter = new BibleChapter;
                      $chapter->verses = $verses;
                      return $chapter; 
                    }

       
                  }
            },
      ];
    }

}

class ViewerType extends ObjectType {

  public function __construct(TypeResolver $typeResolver)
    {

    // SingularFieldName, PluralFieldName, TypeForResolver, ORMName, isUserContext?
    $models = [
      ['note','notes',NoteType::class, 'notes', Note::class],
      ['bible','bibles',BibleType::class, 'bibles', Bible::class],
      ['bibleBook','bibleBooks',BibleBookType::class, 'bibleBooks', BibleBook::class],
      ['bibleChapter','bibleChapters',BibleChapterType::class, 'bibleChapters', BibleChapter::class],
      ['bibleVerse','bibleVerses',BibleVerseType::class, 'bibleVerses', BibleVerse::class],
      ['cossReference','crossReferences',CrossReferenceType::class, 'crossReferences', CrossReference::class],
      ['library','libraries',LibraryType::class, 'libraries', Library::class],
      ['course','courses',CourseType::class, 'courses', Course::class],
      ['lesson','lessons',LessonType::class, 'lessons', Lesson::class],
      ['step','steps',StepType::class, 'steps', Step::class],
      ['user','users',UserType::class, 'users', User::class],
      ['userNavigation','userNavigations',NavigationType::class, 'navigations',true],
      ['userNote','userNotes', UserNoteType::class, 'notes', Note::class, true],
      ['userCourse','userCourses', UserCourseType::class, 'courses', Course::class, true],
      ['userLesson','userLessons', UserLessonType::class, 'lessons', Lesson::class, true],
      ['userTrack','userTracks', TrackType::class, 'tracks', Track::class, true],
      ['resource','resources', ResourceType::class, 'resources', Resource::class],
    ];

    $basic_models = [];

    foreach($models AS $model){
      $basic_models[$model[0]] = OneAndMany::one($typeResolver, $model);
      $basic_models[$model[1]] = OneAndMany::many($typeResolver, $model);
    }

        return parent::__construct([
            'name' => 'Viewer',
            'description' => '',
            'fields' => array_merge( $basic_models,
              [
              'error' => ['type' =>  $typeResolver->get(ErrorType::class)],
              'id' => ['type' => Type::string()],
              'name' => ['type' => Type::string()],
              'email' => ['type' => Type::string()],
              'verified' => ['type' => Type::string()],
              'role' => ['type' => Type::int()],
              'password' => ['type' => Type::string()],
              'remember_token' => ['type' => Type::string()],
              'nickname' => ['type' => Type::string()],
              'url' => ['type' => Type::string()],
              'lang' => ['type' => Type::string()],
              'lastStep' => ['type' => Type::string()],
              'authenticated' => ['type' =>Type::boolean()]
          ]),
           'interfaces' => []
        ]);
    }

}
