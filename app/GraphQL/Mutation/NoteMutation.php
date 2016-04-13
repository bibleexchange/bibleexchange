<?php namespace BibleExchange\GraphQL\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;    
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth, Response,HttpResponse, JWTAuth;

class NoteMutation extends Mutation {
	
	protected $attributes = [
		'name' => 'note'
	];

	public function type()
	{
		return GraphQL::type('note');
	}

	public function args()
	{
		return [
			'body' => ['name' => 'body', 'type' => Type::string()],
			'bible_verse_id' => ['name' => 'bible_verse_id', 'type' => Type::string()],
			'token' => ['name' => 'token', 'type' => Type::string()],
		];
	}

	public function resolve($root, $args)
	{
		
		$user = JWTAuth::toUser($args['token']);
		
		if(!$user){
			abort(403, 'token expired! Sign in.');
		}else{			
			$b = $user->newNote();
			$b->body = $args['body'];
			$b->bible_verse_id = $args['bible_verse_id'];
			$b->save();
			return $b;
		}
	}
}