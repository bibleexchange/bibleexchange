<?php namespace BibleExchange\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;    
use BibleExchange\Entities\BibleChapter;
use GraphQL\Type\Definition\ResolveInfo;
	
    class BibleChaptersQuery extends Query {

        protected $attributes = [
            'name' => 'Bible chapters query'
        ];

        public function type()
        { 
            return Type::listOf(GraphQL::type('biblechapter'));
        }

        public function args()
        {
            return [
                'id' => ['name' => 'id', 'type' => Type::string()],
                'summary' => ['name' => 'summary', 'type' => Type::string()],
                'reference' => ['name' => 'reference', 'type' => Type::string()]
            ];
        }

        public function resolve($root, $args, ResolveInfo $info)
        {
        
			$fields = $info->getFieldSelection($depth = 3);

			$biblechapters = BibleChapter::query();

			foreach ($fields as $field => $keys) {
				
				/// localhost/graphql?query=query+FetchBibleChapter{biblechapters(id:"1"){id,verses{id}}}
				if($field === 'verses') {
					$biblechapters->with('verses');
				}
			}
			
			if(isset($args['id'])){
                return $biblechapters->where('id' , $args['id'])->get();
            }elseif(isset($args['orderBy'])){
                return $biblechapters->get()->where('orderBy' , $args['orderBy']);
            }elseif(isset($args['reference'])){
                return $biblechapters->get()->where('reference' , $args['reference']);
            }else{
                return $biblechapters->get();
            }		
			
        }

    }