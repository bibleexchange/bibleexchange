<?php namespace BibleExchange\GraphQL\Query;

    use GraphQL;
    use GraphQL\Type\Definition\Type;
    use BibleExchange\GraphQL\Support\Query;
    use BibleExchange\Entities\PageInfo;

    class PageInfoQuery extends Query {

        protected $attributes = [
            'name' => 'PageInfo query'
        ];

        public function type()
        {
            return GraphQL::type('pageinfo');
        }

        public function args()
        {
          return [
				'type' => ['name' => 'type', 'type' => Type::string()],
				'page' => ['name' => 'page', 'type' => Type::int()],
				'perpage' => ['name' => 'perpage', 'type' => Type::int()]
            ];
        }

        public function resolve($root, $args)
        {
			//http://localhost/graphql?query=query+FetchNotebooks($page:Int){notebooks(page:$page){id,title,bible_verse_id,owner{username},notes{id,body},url},pageinfo(type:%22notebooks%22,page:10,perpage:10){numberOfPages,hasNextPage,perPage,hasPreviousPage,perPage}}&&param={page:1}

			$type = $args['type'];
			$currentPage = $args['page'];
			$perPage = $args['perpage'];
			
			$page = new PageInfo($type, $currentPage, $perPage);
			
			return $page;
			
        }

    }