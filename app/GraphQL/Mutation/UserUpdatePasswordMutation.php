<?php

namespace BibleExperience\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\InputObjectType;
use Nuwave\Relay\Support\Definition\RelayMutation;
use BibleExperience\User;

class UserUpdatePasswordMutation extends RelayMutation
{
    /**
     * Name of mutation.
     *
     * @return string
     */
    protected function name()
    {
        return 'UserUpdatePasswordMutation';
    }

    /**
     * Available input fields for mutation.
     *
     * @return array
     */
    public function inputFields()
    {
        return [
            'id' => [
                'type' => Type::int(),
                'rules' => ['required']
            ],
            'password' => [
                'type' => Type::string(),
                'rules' => ['required', 'min:8']
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
        $user = User::find($input['id']);
        $user->password = \Hash::make($input['password']);
        $user->save();

        return ['',$user];
    }
}
