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
				'bible_verse_id' => ['name' => 'bible_verse_id', 'type' => Type::string()],
				'page' => ['name' => 'page', 'type' => Type::string()]
            ];
        }

        public function resolve($root, $args)
        {

            if(isset($args['id']))
            {
				//http://localhost/graphql?query=query+FetchNotebooks{notes(id:%227%22){id,body}}
                $notebook = Notebook::where('id' , $args['id'])->with('notes')->get();
				
				return $notebook;
            }
            else if(isset($args['bible_verse_id']))
            {
				//http://localhost/graphql?query=query+FetchNotebooks{notes(bible_verse_id:%2254004012%22){id,body}}
                return Notebook::where('bible_verse_id', $args['bible_verse_id'])->get();
            }else if(isset($args['page']))
            {
				//http://localhost/graphql?query=query+FetchNotebooks{notebooks(page:%221%22){id,title,bible_verse_id,notes{id,body},user{username}}}
				$perPage = 10;
				$skip = (intval($args['page'])-1) * $perPage;
				$notebooks = Notebook::skip($skip)->take($perPage)->get();
                return $notebooks;
            }
            else
            {
               $notebooks = Notebook::skip(0)->take(5)->get();
				
                return $notebooks;
            }
        }

    }