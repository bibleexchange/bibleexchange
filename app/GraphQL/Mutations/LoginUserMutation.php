<?php namespace BibleExchange\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\InputObjectType;
use Nuwave\Relay\Support\Definition\RelayMutation;
use BibleExchange\Entities\User;

use Event;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth, Response,HttpResponse, JWTAuth;

class LoginUserMutation extends RelayMutation {
		
	/**
     * Name of mutation.
     *
     * @return string
     */
    protected function name()
    {
        return 'LoginUserMutation';
    }

    /**
     * Available input fields for mutation.
     *
     * @return array
     */
    public function inputFields()
    {
        return [
            'email' => [
                'type' => Type::string(),
                'rules' => ['required']
            ],
            'password' => [
                'type' => Type::string(),
				'rules' => ['required', 'min:5']
            ]
        ];
    }

    /**
     * Fields that will be sent back to client.
     *
     * @return array
     */
    protected function outputFields()
    {
        return [
            'user' => [
                'type' => GraphQL::type('user'),
                'resolve' => function (User $user) {
                    return $user;
                }
            ]
        ];
    }

    /**
     * Perform data mutation.
     *
     * @param  array       $input
     * @param  ResolveInfo $info
     * @return array
     */
    protected function mutateAndGetPayload(array $input, ResolveInfo $info)
    {
		$credentials = ['email'=>$input['email'],'password'=>$input['password']];
		
		 if ( ! $token = JWTAuth::attempt($credentials)) {
			   abort(403, 'Not valid credentials');
		   }
		
		$user = JWTAuth::toUser($token);
		
		return $user;
		
		/*
			JWTAuth::invalidate($args['logout']);
			Auth::logout();
		*/
		
    }
		
}