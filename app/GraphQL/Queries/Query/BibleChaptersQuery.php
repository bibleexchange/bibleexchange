<?php namespace BibleExperience\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use BibleExperience\GraphQL\Support\Query;    
use BibleExperience\Entities\BibleChapter;
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
				if($field === 'verses') {
					$biblechapters->with('verses','notes');
				}
			}
			
			if(isset($args['id'])){
				//http://localhost/graphql?query=query+FetchBibleChapter($id:String){biblechapters(id:$id){id,verses{id},notes{object_type,relatedObject}}}&&params={"id":"1170"}
                return $biblechapters->where('id' , $args['id'])->get();
            }elseif(isset($args['orderBy'])){
                return $biblechapters->get()->where('orderBy' , $args['orderBy']);
            }elseif(isset($args['reference'])){
				//http://localhost/graphql?query=query+FetchBibleChapter($reference:String){biblechapters(reference:$reference){id,reference,verses{body,b,c,v,reference,url,chapterURL,notes{id,body,user{username},object_type,relatedObject}},notes{object_type,relatedObject}}}&&params={"reference":"Matthew 1"}	
                return $biblechapters->searchReference($args['reference'])->get();
            }else{
                return $biblechapters->get();
            }		
			
        }

    }