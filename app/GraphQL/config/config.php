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
    'routes' => '/graphql',
    
    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\BibleExchange\GraphQL\GraphQLController@query',
    //     'mutation' => '\BibleExchange\GraphQL\GraphQLController@mutation'
    // ]
    //
   'controllers' => '\BibleExchange\GraphQL\GraphQLController@query',

    // Any middleware for the graphql route group
    'middleware' => ['cors'],
    
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
			 'biblechapters' => 'BibleExchange\GraphQL\Query\BibleChaptersQuery',
			 'notes' => 'BibleExchange\GraphQL\Query\NotesQuery',
			 'notebooks' => 'BibleExchange\GraphQL\Query\NotebooksQuery',
			 'notifications' => 'BibleExchange\GraphQL\Query\NotificationsQuery',
			 'pageinfo' => 'BibleExchange\GraphQL\Query\PageInfoQuery',
        ],
        'mutation' => [
			'userSession' => 'BibleExchange\GraphQL\Mutation\UserSessionMutation',
			'userCreate' => 'BibleExchange\GraphQL\Mutation\UserCreateMutation',
			'userBookmark' => 'BibleExchange\GraphQL\Mutation\UserBookmarkMutation',
			'noteCreate' => 'BibleExchange\GraphQL\Mutation\NoteMutation',
        ]
    ],
    
    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'App\GraphQL\Type\UserType'
    // ]
    //
    'types' => [

		 'biblechapter' => 'BibleExchange\GraphQL\Type\BibleChapterType',
		 'bibleverse' => 'BibleExchange\GraphQL\Type\BibleVerseType',
		 'biblebook' => 'BibleExchange\GraphQL\Type\BibleBookType',
		 'bookmark' => 'BibleExchange\GraphQL\Type\BookmarkType',
		 'note' => 'BibleExchange\GraphQL\Type\NoteType',
		 'notebook' => 'BibleExchange\GraphQL\Type\NotebookType',
		 'notification' => 'BibleExchange\GraphQL\Type\NotificationType',
		 'pageinfo' => 'BibleExchange\GraphQL\Type\PageInfoType',
		 'user' => 'BibleExchange\GraphQL\Type\UserType',
    ]
    
];
