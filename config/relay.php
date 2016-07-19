<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Namespace registry
    |--------------------------------------------------------------------------
    |
    | This package provides a set of commands to make it easy for you to
    | create new parts in your GraphQL schema. Change these values to
    | match the namespaces you'd like each piece to be created in.
    |
    */

    'namespaces' => [
        'mutations' => 'BibleExperience\\GraphQL\\Mutations',
        'queries'   => 'BibleExperience\\GraphQL\\Queries',
        'types'     => 'BibleExperience\\GraphQL\\Types',
        'fields'    => 'BibleExperience\\GraphQL\\Fields',
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema declaration
    |--------------------------------------------------------------------------
    |
    | This is a path that points to where your Relay schema is located
    | relative to the app path. You should define your entire Relay
    | schema in this file. Declare any Relay queries, mutations,
    | and types here instead of laravel-graphql config file.
    |
    */

    'schema' => [
        'path'      => 'Http/schema.php',
        'output'    =>  __DIR__.'../../../be-front-new/server/data/schema.json',
    ],

    'controller' => 'Nuwave\Relay\Http\Controllers\LaravelController@query',
    'model_path' => 'BibleExperience\\Entities',
    'camel_case' => false,
	'eloquent' => [
		'path' => 'BibleExperience\\Entities',
		'camel_case' => false
	]
];
