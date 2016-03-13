<?php namespace BibleExchange\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;    
use BibleExchange\Entities\User as User;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
			'logout' => ['name' => 'logout', 'type' => Type::string()],
		];
	}

	public function resolve($root, $args)
	{
		
		  if(isset($args['email']) && isset($args['password']) )
            {
				//http://localhost/graphql?query=mutation+LoginUser{loginUser(email:%22sgrjr@deliverance.me%22,password:%221230happy%22){id,email}}	
				$token = $this->authenticate($args['email'],$args['password']);
				return $this->getAuthUser($token);
            }
            else if(isset($args['logout']))
            {
				//http://localhost/graphql?query=mutation+UserSession{userSession(logout:"true"){id}}		
				if($args['logout'] === "true"){
					//Auth::logout();
				}
            }
	}
	
	public function authenticate($email,$password)
    {
		$credentials = ["email"=>$email,"password"=>$password];
		
        try {
            // attempt to verify the credentials and create a token for the current user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // error while attempting to encode token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
 
        // all good, return the token
       // return response()->json($token);
	   return $token;
    }
	
	public function getAuthUser($key)
	{
		try {
			if (! $user = JWTAuth::parseToken($key)->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['token_expired'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['token_invalid'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['token_absent'], $e->getStatusCode());
		}
		// Token is valid and we have found the user via the sub claim
		return response()->json($user);
	}
	
}