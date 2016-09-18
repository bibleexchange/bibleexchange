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
    'controllers' => '\Folklore\GraphQL\GraphQLController@query',

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
    //          'users' => 'BibleExperience\GraphQL\Query\UsersQuery'
    //      ],
    //     'mutation' => [
    //          
    //     ]
    // ]
    //
    'schema' => [
        'query' => [
	     'courses' => 'BibleExperience\GraphQL\Query\CoursesQuery',
	     'course' => 'BibleExperience\GraphQL\Query\CourseQuery',
             'users' => 'BibleExperience\GraphQL\Query\UsersQuery',
	     'viewer' => 'BibleExperience\GraphQL\Query\ViewerQuery',
	     'bibleChapter' => 'BibleExperience\GraphQL\Query\BibleChapterQuery',
	     'bibleVerse' => 'BibleExperience\GraphQL\Query\BibleVerseQuery',
	     'bible' => 'BibleExperience\GraphQL\Query\BibleQuery',
	     'step' => 'BibleExperience\GraphQL\Query\StepQuery',
	     'node' => 'BibleExperience\GraphQL\Query\NodeQuery'
        ],
        'mutation' => [
            'updateCourse' => 'BibleExperience\GraphQL\Mutation\UpdateCourseMutation'
        ]
    ],
    
    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'BibleExperience\GraphQL\Type\UserType'
    // ]
    //
    'types' => [
	'attachment' => 'BibleExperience\GraphQL\Type\AttachmentType',
	'attachmentClass' => 'BibleExperience\GraphQL\Type\AttachmentClassType',
	'bible' => 'BibleExperience\GraphQL\Type\BibleType',
	'bibleBook' => 'BibleExperience\GraphQL\Type\BibleBookType',
	'bibleChapter' => 'BibleExperience\GraphQL\Type\BibleChapterType',
	'bibleVerse' => 'BibleExperience\GraphQL\Type\BibleVerseType',
	'bookmark' => 'BibleExperience\GraphQL\Type\BookmarkType',
	'course' => 'BibleExperience\GraphQL\Type\CourseType',
	'step' => 'BibleExperience\GraphQL\Type\StepType',
	'navHistory' => 'BibleExperience\GraphQL\Type\NavHistoryType',
	'note' => 'BibleExperience\GraphQL\Type\NoteType',
	'notification' => 'BibleExperience\GraphQL\Type\NotificationType',
	'obj' => 'BibleExperience\GraphQL\Type\ObjType',
	'user' => 'BibleExperience\GraphQL\Type\UserType',
	'node' => 'BibleExperience\GraphQL\Type\NodeType',
	'pageInfo' => 'BibleExperience\GraphQL\Type\PageInfoType'
    ],
    
    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    'error_formatter' => ['\Folklore\GraphQL\GraphQL', 'formatError']
    
];
