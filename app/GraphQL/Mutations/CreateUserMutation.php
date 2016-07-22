<?php namespace BibleExperience\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\InputObjectType;
use Nuwave\Relay\Support\Definition\RelayMutation;
use BibleExperience\User;

class CreateUserMutation extends RelayMutation {
		
	/**
     * Name of mutation.
     *
     * @return string
     */
    protected function name()
    {
        return 'CreateUserMutation';
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
				'rules' => ['required', 'min:15']
            ]
        ];
    }

    /**
     * Rules for mutation.
     *
     * Note: You can add your rules here or define
     * them in the inputFields
     *
     * @return array
     */
    public function rules()
    {
        return [
           //'password' => ['required']
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
		$user = new User();
		$user->setPasswordAttribute($input['password']);
		$user->email = $input['email'];
		$user->save();

		return $user;
    }
		
}