<?php namespace BibleExchange\GraphQL\Query;

    use GraphQL;
    use GraphQL\Type\Definition\Type;
    use BibleExchange\GraphQL\Support\Query;    
    use BibleExchange\Entities\Note;

    class NotesQuery extends Query {

        protected $attributes = [
            'name' => 'Notes query'
        ];

        public function type()
        {
            return Type::listOf(GraphQL::type('note'));
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
				//http://localhost/graphql?query=query+FetchNotes{notes(id:%22256%22){id,body,object_type,relatedObject}}
                return Note::where('id' , $args['id'])->get();
            }
            else if(isset($args['bible_verse_id']))
            {
				//http://localhost/graphql?query=query+FetchNotes{notes(bible_verse_id:%2254004012%22){id,body,relatedObject}}
                return Note::where('bible_verse_id', $args['bible_verse_id'])->get();
            }
            else
            {
                return false;
            }
        }

    }