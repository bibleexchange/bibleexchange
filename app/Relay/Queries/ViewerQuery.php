<?php namespace BibleExperience\Relay\Queries;

//use GraphQL\Type\Definition\EnumType;
//use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

use BibleExperience\Relay\Types\NodeType AS Node;
use BibleExperience\Relay\Types\BibleType AS Bible;
use BibleExperience\Relay\Types\BibleBookType AS BibleBook;
use BibleExperience\Relay\Types\BibleChapterType AS BibleChapter;
use BibleExperience\Relay\Types\BibleVerseType AS BibleVerse;
use BibleExperience\Relay\Types\BibleVersionType AS BibleVersion;
use BibleExperience\Relay\Types\CourseType AS Course;
use BibleExperience\Relay\Types\UserType AS User;
use BibleExperience\Relay\Types\ViewerType AS Viewer;

use BibleExperience\Bible as BibleModel;
use BibleExperience\BibleChapter as BibleChapterModel;
use BibleExperience\BibleVerse as BibleVerseModel;
use BibleExperience\Course as CourseModel;
use BibleExperience\Library as LibraryModel;
use BibleExperience\User as UserModel;

class ViewerQuery extends ObjectType {

use GlobalIdTrait;

    public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'ViewerQuery',
            'fields' => [
 	       'viewer' => [
                  'type' => $typeResolver->get(Viewer::class),
                  'args' => [],
                  'resolve' => function ($root, $args) {
                      return new UserModel;
                  },
              ],
              'user' => [
                  'type' => $typeResolver->get(User::class),
                  'args' => [
                      'token' => [
                          'description' => 'JWT Token for User',
                          'type' => Type::string(),
                      ]
                  ],
                  'resolve' => function ($root, $args) {
                      return UserModel::getOrLogin(isset($args['token']) ? $args['token'] : null);
                  },
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
                            return BibleChapterModel::find($decoded[1]);
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
                            return BibleVerseModel::find($decoded[1]);
                          }else{
                            return BibleVerseModel::find($args['id']);
                          }


                        } else {
                          return BibleVerseModel::findByReference($args['reference']);
                        }
                    },
                ],
                'course' => [
                    'type' => Type::nonNull($typeResolver->get(Course::class)),
                    'args' => [
                        'id' => [
                            'name' => 'id',
                            'description' => 'id of the course.',
                            'type' => Type::string()
                        ]
                    ],
                    'resolve' => function ($root, $args){

                          $decoded = $this->decodeGlobalId($args['id']);

                          if(is_array($decoded) && count($decoded) > 1){
                            return CourseModel::find($decoded[1]);
                          }else{
                            return CourseModel::find($args['id']);
                          }

                    },
                ],
                'node' => [
                    'type' => $typeResolver->get(Node::class),
                    'args' => [
                        'id' => [
                            'name' => 'id',
                            'description' => 'id of an Object',
                            'type' => Type::nonNull(Type::id())
                        ]
                    ],
                    'resolve' => function ($root, $args) {

                    	list($typeClass, $id) = $this->decodeGlobalId($args['id']);
			return ucfirst($typeClass)::modelFind($id, $typeClass);
                    }
                ],
	   ]
	]);
    }

}
