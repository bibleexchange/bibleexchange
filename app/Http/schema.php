<?php

Relay::group(['namespace' => 'BibleExperience\\GraphQL', 'middleware' => ['auth.viewer','cors']], function () {
    Relay::group(['namespace' => 'Mutations'], function () {
		//Relay::mutation('createUser', 'CreateUserMutation');
		//Relay::mutation('loginUser', 'LoginUserMutation');
		Relay::mutation('updatePassword', 'UpdatePasswordMutation');
    });

    Relay::group(['namespace' => 'Queries'], function () {
        Relay::query('viewerQuery', 'ViewerQuery');
		//Relay::query('bibleQuery', 'BibleQuery');
		//Relay::query('courseQuery', 'CourseQuery');
    });

    Relay::group(['namespace' => 'Types'], function () {
		
		//Relay::type('bible', 'BibleType');
		//Relay::type('bibleBook', 'BibleBookType');
		//Relay::type('bibleChapter', 'BibleChapterType');
		//Relay::type('bibleVerse', 'BibleVerseType');
		
		//Relay::type('note', 'NoteType');
		
		//Relay::type('chapter', 'ChapterType');
		//Relay::type('course', 'CourseType');
		//Relay::type('module', 'ModuleType');
		//Relay::type('notification', 'NotificationType');
		//Relay::type('step', 'StepType');
		Relay::type('user', 'UserType');
		//Relay::type('viewer', 'ViewerType');
    });
});