<?php

namespace BibleExperience\GraphQL\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\InputObjectType;
use Nuwave\Relay\Support\Definition\RelayMutation;

class UserLogin extends RelayMutation
{
    /**
     * Name of mutation.
     *
     * @return string
     */
    protected function name()
    {
        return 'UserLogin';
    }

    /**
     * Available input fields for mutation.
     *
     * @return array
     */
    public function inputFields()
    {
        return [];
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
        return [];
    }

    /**
     * Fields that will be sent back to client.
     *
     * @return array
     */
    protected function outputFields()
    {
        return [];
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
        // TODO: Perform mutation
    }
}
