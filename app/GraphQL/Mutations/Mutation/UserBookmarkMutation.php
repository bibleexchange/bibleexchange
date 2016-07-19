<?php namespace BibleExperience\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use BibleExperience\GraphQL\Support\Mutation;    
use BibleExperience\Entities\User;
use BibleExperience\Entities\UserRepository;

use Event;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth, Response,HttpResponse, JWTAuth;

class UserBookmarkMutation extends Mutation {
	
	protected $attributes = [
		'name' => 'userBookmark'
	];

	public function type()
	{
		return GraphQL::type('bookmark');
	}

	public function args()
	{
		return [
			'url' => ['name' => 'url', 'type' => Type::string()],
			'token' => ['name' => 'token', 'type' => Type::string()],
			'action' => ['name' => 'action', 'type' => Type::string()],
		];
	}

	public function resolve($root, $args)
	{
		
		$user = JWTAuth::toUser($args['token']);
		
		if(!$user){
			abort(403, 'token expired! Sign in.');
		}else{
	
			switch ($args['action']) {
				case 'create':
					// http://localhost/graphql?query=mutation+UserBookmark{userBookmark(token:"__TOKEN__",url:"__URL__",action:"create"){url,user{id}}}
					$b = $user->newBookmark();
					$b->url = $args['url'];
					$b->save();
					return $b;
					break;
				case 'delete':
					// http://localhost/graphql?query=mutation+UserBookmark{userBookmark(token:"__TOKEN__",url:"__URL__",action:"delete"){url}}
					
					$user->bookmarks()->where('url',$args['url'])->delete();
					return null;
					break;

				default:
					abort(403, 'Action does not match anything I have!');
			}			
		}
	}
}