<?php namespace BibleExchange\GraphQL\Query;

    use GraphQL;
    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Query;    
    use BibleExchange\Entities\Notebook;

    class NotebooksQuery extends Query {

        protected $attributes = [
            'name' => 'Notebooks query'
        ];

        public function type()
        {
            return Type::listOf(GraphQL::type('notebook'));
        }

        public function args()
        {
            return [
                'id' => ['name' => 'id', 'type' => Type::string()],
				'bible_verse_id' => ['name' => 'bible_verse_id', 'type' => Type::string()]
            ];
        }

        public function resolve($root, $args)
        {

            if(isset($args['id']))
            {
				//http://localhost/graphql?query=query+FetchNotebooks{notes(id:%227%22){id,body}}
                return Notebook::where('id' , $args['id'])->get();
            }
            else if(isset($args['bible_verse_id']))
            {
				//http://localhost/graphql?query=query+FetchNotebooks{notes(bible_verse_id:%2254004012%22){id,body}}
                return Notebook::where('bible_verse_id', $args['bible_verse_id'])->get();
            }
            else
            {
                return false;
            }
        }

    }