<?php namespace BibleExchange\GraphQL\Query;

    use GraphQL;
    use GraphQL\Type\Definition\Type;
    use BibleExchange\GraphQL\Support\Query;    
    use BibleExchange\Entities\BibleVerse;

    class BibleVersesQuery extends Query {

        protected $attributes = [
            'name' => 'Bible verses query'
        ];

        public function type()
        {
            return Type::listOf(GraphQL::type('bibleverse'));
        }

        public function args()
        {
            return [
                'id' => ['name' => 'id', 'type' => Type::string()],
				'bible_chapter_id' => ['name' => 'bible_chapter_id', 'type' => Type::string()],
				'reference' => ['name' => 'reference', 'type' => Type::string()]
            ];
        }

        public function resolve($root, $args)
        {

            if(isset($args['id']))
            {
			// http://localhost/graphql?query=query+FetchBibleVerses{bibleverses(id:%2201001001%22){id,body,notes{object_type,relatedObject}}}
              return BibleVerse::where('id' , $args['id'])->with('notes')->get();
			 // return BibleVerse::where('id' , $args['id'])->get();
            }
            else if(isset($args['bible_chapter_id']))
            {
				// http://localhost/graphql?query=query+FetchBibleVerses{bibleverses(bible_chapter_id:%2272%22){id,body}}
                return BibleVerse::where('bible_chapter_id', $args['bible_chapter_id'])->with('notes')->get();
            }
            else if(isset($args['reference']))
            {
            	//dd($args['reference']);
				//localhost/graphql?query=query+FetchBibleVerses{bibleverses(reference:"Matthew 1:1"){id,body}}
                return BibleVerse::referenceTranslator($args['reference']);
            }
            else
            {
                return BibleVerse::where('id', '01001001')->with('notes')->get();
            }
        }

    }