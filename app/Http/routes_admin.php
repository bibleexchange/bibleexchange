<?php
/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth|admin'), function()
{
	# Audio Management
	Route::get('audios', 'AdminAudiosController@index');
	Route::post('audios', 'AdminAudiosController@store');
	Route::post('audios/{audio}/update', 'AdminAudiosController@update');
	
	# Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Lesson Management
    Route::get('lessons/{lesson}/show', 'AdminLessonsController@getShow');
    Route::get('lessons/{lesson}/edit', 'AdminLessonsController@getEdit');
    Route::post('lessons/{lesson}/edit', 'AdminLessonsController@postEdit');
	Route::get('lessons/{lesson}/publish', 'AdminLessonsController@getPublish');
    Route::get('lessons/{lesson}/delete', 'AdminLessonsController@getDelete');
    Route::post('lessons/{lesson}/delete', 'AdminLessonsController@postDelete');
    Route::controller('lessons', 'AdminLessonsController');
	
	# Course Management
    Route::get('courses/{course}/show', 'AdminCoursesController@getShow');
    Route::get('courses/{course}/edit', 'AdminCoursesController@getEdit');
    Route::post('courses/{course}/edit', 'AdminCoursesController@postEdit');
    Route::get('courses/{course}/delete', 'AdminCoursesController@getDelete');
    Route::post('courses/{course}/delete', 'AdminCoursesController@postDelete');
    Route::controller('courses', 'AdminCoursesController');
	
	# Plans Managament
	Route::get('plans/data', 'AdminPlansController@getData');
	Route::resource('plans', 'AdminPlansController');
	
	# Transcripts Management
	Route::resource('transcripts', 'AdminTranscriptsController');
	
    # User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');
	
    
    
    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
	
});
