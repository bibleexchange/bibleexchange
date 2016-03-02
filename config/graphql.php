<?php

return [
    
    // The prefix for routes
    'prefix' => 'graphql',
    
    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // 'routes' => [
    //     'query' => '/query',
    //     'mutation' => '/mutation'
    // ]
    //
    'routes' => '/',
    
    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Folklore\GraphQL\GraphQLController@query',
    //     'mutation' => '\Folklore\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers' => [
         'query' => '\Folklore\GraphQL\GraphQLController@query',
         'mutation' => '\Folklore\GraphQL\GraphQLController@mutation'
     ],

    // Any middleware for the graphql route group
    'middleware' => [],
    
    // The schema for query and/or mutation. It expects an array to provide
    // both the 'query' fields and the 'mutation' fields. You can also
    // provide directly an object GraphQL\Schema
    //
    // Example:
    //
    // 'schema' => new Schema($queryType, $mutationType)
    //
    // or
    //
    // 'schema' => [
    //     'query' => [
    //          'users' => 'App\GraphQL\Query\UsersQuery'
    //      ],
    //     'mutation' => [
    //          
    //     ]
    // ]
    //
    'schema' => [
        'query' => [
             'users' => 'BibleExchange\GraphQL\Query\UsersQuery',
			 'biblebooks' => 'BibleExchange\GraphQL\Query\BibleBooksQuery',
			 'bibleverses' => 'BibleExchange\GraphQL\Query\BibleVersesQuery',
			 'biblechapters' => 'BibleExchange\GraphQL\Query\BibleChaptersQuery'
        ],
        'mutation' => [

        ]
    ],
    
    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    'types' => [

		 'biblechapter' => 'BibleExchange\GraphQL\Type\BibleChapterType',
		 'user' => 'BibleExchange\GraphQL\Type\UserType',
		 'bibleverse' => 'BibleExchange\GraphQL\Type\BibleVerseType',
		 'biblebook' => 'BibleExchange\GraphQL\Type\BibleBookType'
    ]
    
];
