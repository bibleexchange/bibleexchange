<?php namespace BibleExchange\GraphQL\Query;

    use GraphQL;
    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Query;    
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
                'text' => ['name' => 'text', 'type' => Type::string()],
				'bible_chapter_id' => ['name' => 'bible_chapter_id', 'type' => Type::string()],
				'reference' => ['name' => 'reference', 'type' => Type::string()]
            ];
        }

        public function resolve($root, $args)
        {

            if(isset($args['id']))
            {
			//localhost/graphql?query=query+FetchBibleVerses{bibleverses(id:"01001001"){id,text}}
                return BibleVerse::where('id' , $args['id'])->get();
            }
            else if(isset($args['bible_chapter_id']))
            {
				//localhost/graphql?query=query+FetchBibleVerses{bibleverses(bible_chapter_id:"72"){id,text}}
                return BibleVerse::where('bible_chapter_id', $args['bible_chapter_id'])->get();
            }
            else if(isset($args['reference']))
            {
            	//dd($args['reference']);
				//localhost/graphql?query=query+FetchBibleVerses{bibleverses(reference:"Matthew 1:1"){id,text}}
                return BibleVerse::referenceTranslator($args['reference']);
            }
            else
            {
                return BibleVerse::where('id', '01001001')->get();
            }
        }

    }