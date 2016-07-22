<?php namespace BibleExperience\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use BibleExperience\GraphQL\Support\Mutation;    
use BibleExperience\User;
use BibleExperience\UserRepository;

use Event;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth, Response,HttpResponse;

use BibleExperience\Commands\RegisterUserCommand;
use BibleExperience\Events\UserWasRegistered;

class UserCreateMutation extends Mutation {
	
	protected $attributes = [
		'name' => 'userCreate'
	];

	public function type()
	{
		return GraphQL::type('user');
	}

	public function args()
	{
		return [
			'email' => ['name' => 'email', 'type' => Type::string()],
			'password' => ['name' => 'password', 'type' => Type::string()]
		];
	}

	public function resolve($root, $args)
	{
		
		  if(isset($args['email']) && isset($args['password']) )
            {
				// /graphql?query=mutation+UserCreate{userCreate(email:"sgrjr@deliverance.me",password:"1230happy"){id,email,token}}
				//Check if a user with the provided email exists already. returns "null" if not. returns an instance of that user model if so.
			   $user = UserRepository::findByEmail($args['email']);

			   //If User isn't null respond with an error; otherwise, dispatch register user command
			   if( $user == null ){
					$user = $this->dispatch(new RegisterUserCommand($args['email'], $args['password']));
					$user = User::register($args['email'], $args['password']);
					//temporary hack until I fix email confirmation workflow, automatiically 'confirming' email here:
					$user->confirmation_code = null;
					$user->confirmed = 1;
					// end hack
					$user->save();
					Event::fire(new UserWasRegistered($user));
					
			   }else{
				   abort(403, 'User with that email already exists!');
			   }
				
				Auth::login($user);

				return Auth::user();
			}
			
			abort(403, 'GraphQL request does not match anything I have :(');
			
	}
	
	
}