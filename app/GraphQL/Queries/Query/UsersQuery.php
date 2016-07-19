<?php namespace BibleExperience\GraphQL\Query;

    use GraphQL;
    use GraphQL\Type\Definition\Type;
    use BibleExperience\GraphQL\Support\Query;    
    use BibleExperience\Entities\User;

    class UsersQuery extends Query {

        protected $attributes = [
            'name' => 'Users query'
        ];

        public function type()
        {
            return Type::listOf(GraphQL::type('user'));
        }

        public function args()
        {
            return [
                'id' => ['name' => 'id', 'type' => Type::string()],
                'email' => ['name' => 'email', 'type' => Type::string()]
            ];
        }

        public function resolve($root, $args)
        {

            if(isset($args['id']))
            {
				//localhost/graphql?query=query+FetchUsers{users(id:"2"){id,email}}
                return User::where('id' , $args['id'])->get();
            }
            else if(isset($args['email']))
            {
				//localhost/graphql?query=query+FetchUsers{users(email:"mjamesderocher@gmail.com"){id,email}}
                return User::where('email', $args['email'])->get();
            }
            else
            {
                return User::all();
            }
        }

    }