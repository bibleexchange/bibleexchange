<?php namespace BibleExperience\GraphQL\Query;

    use GraphQL;
    use GraphQL\Type\Definition\Type;
    use BibleExperience\GraphQL\Support\Query;    
    use BibleExperience\Entities\BibleBook;

    class BibleBooksQuery extends Query {

        protected $attributes = [
            'name' => 'Bible books query'
        ];

        public function type()
        {
            return Type::listOf(GraphQL::type('biblebook'));
        }

        public function args()
        {
            return [
                'id' => ['name' => 'id', 'type' => Type::string()],
                'n' => ['name' => 'n', 'type' => Type::string()],
				't' => ['name' => 't', 'type' => Type::string()],
				'g' => ['name' => 'g', 'type' => Type::string()]
            ];
        }

        public function resolve($root, $args)
        {

            if(isset($args['id']))
            {
			//localhost/graphql?query=query+FetchBibleBooks{biblebooks(id:"1"){id,n,t,g}}
                return BibleBook::where('id' , $args['id'])->get();
            }
            else if(isset($args['n']))
            {
				//localhost/graphql?query=query+FetchBibleBooks{biblebooks(n:"genesis"){id,n,t,g}}
                return BibleBook::where('n','like', $args['n'])->get();
            }
           
            else
            {
                return BibleBook::where('id', '1')->get();
            }
        }

    }