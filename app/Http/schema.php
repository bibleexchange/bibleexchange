<?php

Relay::group(['namespace' => 'BibleExperience\\GraphQL', 'middleware' => ['cors']], function () {
    Relay::group(['namespace' => 'Mutations','middleware' => ['auth.viewer']], function () {
	Relay::mutation('userUpdatePassword', 'UserUpdatePasswordMutation');
    });

    Relay::group(['namespace' => 'Queries','middleware'=>[]], function () {
        Relay::query('viewerQuery', 'ViewerQuery');
		Relay::query('bibleChapterQuery', 'BibleChapterQuery');
		Relay::query('bibleVerseQuery', 'BibleVerseQuery');
		Relay::query('bibleQuery', 'BibleQuery');
		Relay::query('courseQuery', 'CourseQuery');
		Relay::query('stepQuery', 'StepQuery');
    });

    Relay::group(['namespace' => 'Types'], function () {
		Relay::type('bible', 'BibleType');
		Relay::type('bibleBook', 'BibleBookType');
		Relay::type('bibleChapter', 'BibleChapterType');
		Relay::type('bibleVerse', 'BibleVerseType');
		Relay::type('bookmark', 'BookmarkType');
		Relay::type('course', 'CourseType');
		Relay::type('navHistory', 'NavHistoryType');
		Relay::type('note', 'NoteType');
		Relay::type('notification', 'NotificationType');
		Relay::type('step', 'StepType');
		Relay::type('user', 'UserType');
    });
});
