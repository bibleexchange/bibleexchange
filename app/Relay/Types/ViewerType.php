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
use BibleExperience\Relay\Types\UserType AS User;

use BibleExperience\User AS UserModel;
use BibleExperience\Bible AS BibleModel;
use BibleExperience\BibleChapter AS BibleChapterModel;
use BibleExperience\BibleVerse AS BibleVerseModel;

class ViewerType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Viewer',
            'description' => '',
            'fields' => [
                'user' => [
                    'type' =>  $typeResolver->get(User::class),
                    'description' => '',
                    'args' => [
          		        'token' => [
          		            'name' => 'token',
          		            'description' => 'token of the user',
          		            'type' => Type::nonNull(Type::string())
          		         ],
                    ],
                    'resolve' => function($root, $args, $resolveInfo){
            			       return $root::getOrLogin(isset($args['token']) ? $args['token'] : null);
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

          ],
           'interfaces' => []
        ]);
    }

}
