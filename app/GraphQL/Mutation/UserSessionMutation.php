<?php namespace BibleExchange\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use BibleExchange\GraphQL\Support\Mutation;    
use BibleExchange\Entities\User;
use BibleExchange\Entities\UserRepository;

use Event;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth, Response,HttpResponse, JWTAuth;

use BibleExchange\Commands\RegisterUserCommand;
use BibleExchange\Events\UserWasRegistered;

class UserSessionMutation extends Mutation {
	
	protected $attributes = [
		'name' => 'userSession'
	];

	public function type()
	{
		return GraphQL::type('user');
	}

	public function args()
	{
		return [
			'email' => ['name' => 'email', 'type' => Type::string()],
			'password' => ['name' => 'password', 'type' => Type::string()],
			'token' => ['name' => 'token', 'type' => Type::string()],
			'logout' => ['name' => 'logout', 'type' => Type::string()]
		];
	}

	public function resolve($root, $args)
	{
		
		  if(isset($args['email']) && isset($args['password']))
            {
				// /graphql?query=mutation+UserSession{userSession(email:"sgrjr@deliverance.me",password:"1230happy"){id,email,token}}
				
				$credentials = ['email'=>$args['email'],'password'=>$args['password']];
		
				 if ( ! $token = JWTAuth::attempt($credentials)) {
					   abort(403, 'Not valid credentials');
				   }
				
				$user = JWTAuth::toUser($token);
				
				return $user;
				
            }
            else if(isset($args['logout']))
            {
				// /graphql?query=mutation+UserSession{userSession(logout:"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3JhcGhxbCIsImlhdCI6MTQ1Nzk3MDc2MywiZXhwIjoxNDU3OTc0MzYzLCJuYmYiOjE0NTc5NzA3NjMsImp0aSI6IjBjNTMzZmZiMmIxMWQ5YmE4NDNkZGY0NzlmMmMxZDk5In0.xrrLDES_HdWTo8BPeoKbfWBCK4EEylsfdKz3oahto1I"){id,email,token}}
				JWTAuth::invalidate($args['logout']);
				Auth::logout();

            }else if(isset($args['token']))
            {
				//http://localhost/graphql?query=mutation+UserSession{userSession(token:"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3JhcGhxbCIsImlhdCI6MTQ1Nzk3MDc2MywiZXhwIjoxNDU3OTc0MzYzLCJuYmYiOjE0NTc5NzA3NjMsImp0aSI6IjBjNTMzZmZiMmIxMWQ5YmE4NDNkZGY0NzlmMmMxZDk5In0.xrrLDES_HdWTo8BPeoKbfWBCK4EEylsfdKz3oahto1I"){id,email,token}}	

				$user = JWTAuth::toUser($args['token']);
				return $user;
			}
	}
	
}