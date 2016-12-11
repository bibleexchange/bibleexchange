<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

use BibleExperience\Relay\Types\UserType as User;
use BibleExperience\Relay\Types\NodeType as Node;

use BibleExperience\Bookmark as BookmarkModel;

class UserBookmarkType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

       return parent::__construct([
            'name' => 'UserBookmark',
            'description' => 'A bookmark',
            'fields' => [
          	'id' => Relay::globalIdField(),
		'url' => [
			'type' => Type::string(),
			'description' => 'The url bookmarked.'
		],
		'user' => [
			'type' => $typeResolver->get(User::class),
			'description' => 'User relationship. Creator of this bookmark.'
		],
		'created_at' => [
			'type' => Type::string(),
			'description' => 'When bookmark was created.'
		],
		'updated_at' => [
			'type' => Type::string(),
			'description' => 'When bookmark was last updated.'
		]
            ],
           'interfaces' => [$typeResolver->get(Node::class)]
        ]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = BookmarkModel::find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }

}
