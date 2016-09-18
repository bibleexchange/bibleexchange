<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Graphql;
    use BibleExperience\GraphQL\Field\StepField;
    use GraphQL\Type\Definition\ObjectType;
    use BibleExperience\GraphQL\Support\Definition\RelayType;
    use BibleExperience\User;
    use Relay;
    
class UserType extends RelayType {

        protected $attributes = [
            'name' => 'User',
            'description' => 'A user'
        ];

    public function resolveById($id)
    {
        return User::find($id);
    }


        public function relayFields()
        {
            return [
		'dataID' => [
			'type' => Type::nonNull(Type::int()),
			'description' => 'The id of the user',
		],
		'email' => [
			'type' => Type::string(),
			'description' => 'The email of user'
		],
		'name' => [
			'type' => Type::string(),
			'description' => 'The name of user'
		],
		'verified' => [
			'type' => Type::string(),
			'description' => ''
		],
/*		'role' => [
			'type' => Type::string(),
			'description' => ''
		],*/
		'remember_token' => [
			'type' => Type::string(),
			'description' => ''
		],
		'password' => [
			'type' => Type::string(),
			'description' => ''
		],
		'authenticated' => [
			'type' => Type::boolean(),
			'description' => ''
		],
		'navHistory' => [
			'type' => Type::listOf(GraphQL::type('navHistory')),
			'description' => 'Navigation History of User'
		],
            ];
        }


        // If you want to resolve the field yourself, you can declare a method
        // with the following format resolve[FIELD_NAME]Field()
        protected function resolveEmailField($root, $args)
        {
            return strtolower($root->email);
        }

    }
