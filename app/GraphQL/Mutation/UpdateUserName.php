<?php

namespace BibleExperience\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\InputObjectType;
use Nuwave\Relay\Support\Definition\RelayMutation;
use BibleExperience\User;

class UpdateUserName extends RelayMutation
{
    /**
     * Name of mutation.
     *
     * @return string
     */
    protected function name()
    {
        return 'UpdateUserName';
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
            'name' => [
                'type' => Type::string()
            ]
	];
    }

    /**
     * Validation rules for mutation.
     * Note: This is optional. You can also place rules on
     * your input fields
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:7']
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
        $user->name = $input['name'];
        $user->save();

        return $user;
    }
}
