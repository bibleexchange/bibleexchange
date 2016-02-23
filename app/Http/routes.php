<?php

//$chapters = BibleExchange\Entities\BibleChapter::where('id',6)->first();
//dd($chapters->nextChapter->id);

Route::get('test','TestReactController@test');

Route::get('dbmigrate', 'Tools\DbMigrationController@index');

//Auth::login(\BibleExchange\Entities\User::find(2), true);

View::composer('*', function()
{	

	View::share('currentUser', \Auth::user());
	View::share('encrypted_csrf_token', \Crypt::encrypt(csrf_token()));
	
	if(\Auth::check()){
		
		$notifications = new \BibleExchange\Entities\NotificationFetcher(\Auth::user());
		$unReadnotifications = $notifications->onlyUnread()->fetch();
		
		View::share('unReadNotifications',$unReadnotifications);
	}
});

Validator::resolver(function($translator, $data, $rules, $messages)
{
	return new BibleExchange\Services\CustomValidator($translator, $data, $rules, $messages);
});

Route::get('/gallery','ImagesController@index');
Route::post('/gallery','ImagesController@copyImageToSession');

Route::get('/images/{src1}/{src2?}/{src3?}/{src4?}','ImagesController@show');

Route::get('/resources/{src1}/{src2?}/{src3?}/{src4?}/{src5?}','ImagesController@wiki');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController'
]);

/* ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
*/
Route::pattern('comment', '[0-9]+');
Route::pattern('section', '[0-9]+');
Route::pattern('lesson', '[0-9]+');
Route::pattern('study', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');
Route::pattern('role', '[0-9]+');
Route::pattern('user', '[0-9]+');

Route::model('course', 'BibleExchange\Entities\Course');
Route::model('user', 'BibleExchange\Entities\User');
Route::model('note', 'BibleExchange\Entities\Note');
Route::model('comment', 'BibleExchange\Entities\Comment');
Route::model('lesson', 'BibleExchange\Entities\Lesson');
Route::model('role', 'BibleExchange\Entities\Role');
Route::model('bookmark', 'BibleExchange\Entities\Bookmark');
Route::model('collection', 'BibleExchange\Entities\Collection');
Route::model('ministry', 'BibleExchange\Entities\Ministry');
Route::model('section', 'BibleExchange\Entities\Section');
Route::model('study', 'BibleExchange\Entities\Study');
Route::model('task', 'BibleExchange\Entities\Task');
Route::model('verse', '\BibleExchange\Entities\BibleVerse');
Route::model('bchapter', '\BibleExchange\Entities\BibleChapter');

Route::bind('book', function($value, $route)
{	
	$results = \BibleExchange\Entities\BibleBook::where('slug','like',$value.'%')->first();
	
	return $results;
});

@include('routes_recording.php');

Route::get('/b', ['uses'=>'UserController@index','as'=>'home']);

//Route::get('/', ['uses'=>'UserController@index','as'=>'home']);
Route::get('/', ['uses'=>'BibleController@index','as'=>'bible']);

Route::get('/store',['uses'=>'MainController@index']);
Route::get('/store/{anything}',['uses'=>'MainController@index'])
	->where('anything','(.*)');

Route::get('/welcome', [
	'as' => 'login_path',
	'uses' => 'WelcomeController@index'
]);

Route::post('/welcome', [
	'as' => 'login_path',
	'uses' => 'SessionsController@store'
]);

/*
 * Registration!
*/
Route::get('/register', [
'as' => 'register_path',
'uses' => 'RegistrationController@create'
]);

Route::get('/register/request-confirmation-email', 'RegistrationController@requestConfirmationEmail');

Route::get('/register/{confirmation_code}', [
'as' => 'confirm_path',
'uses' => 'RegistrationController@confirmUser'
])->where('confirmation_code','(.*)'); 

Route::post('/register', [
'as' => 'register_path',
'uses' => 'RegistrationController@store'
]);

Route::post('/confirm_email', ['uses'=>'RegistrationController@confirmEmailAgain','as'=>'confirm_email']);

/*
 * Sessions
*/

Route::get('logout', [
'as' => 'logout_path',
'uses' => 'SessionsController@destroy'
]);

/*
 * Notes
*/
Route::get('notes', [
	'as' => 'notes_path',
	'uses' => 'NotesController@index'
]);

Route::post('notes', [
	'as' => 'notes_path',
	'uses' => 'NoteController@store'
]);

/*
 * Users
*/

Route::get('members', [
'as' => 'users_path',
'uses' => 'UsersController@index'
]);

Route::get('@{username}', [
'as' => 'profile_path',
'uses' => 'UsersController@show'
]);

Route::get('@{username}/notes', [
'as' => 'public_notes_path',
'uses' => 'UsersController@notes'
]);

Route::get('@{username}/notes/{note}', [
'as' => 'public_note_path',
'uses' => 'UsersController@note'
]);

Route::get('@{username}/amens', [
'as' => 'public_amens_path',
'uses' => 'UsersController@amens'
]);

Route::get('@{username}/following', [
'as' => 'public_following_path',
'uses' => 'UsersController@following'
]);

Route::get('@{username}/followers', [
'as' => 'public_followers_path',
'uses' => 'UsersController@followers'
]);

Route::get('@{username}/studies','StudiesController@userIndex');
Route::get('@{username}/studies/{user_study}','StudiesController@show');

Route::get('@{username}/courses','UserCoursesController@index');

/**
 * Follows
*/
Route::post('follows', [
'as' => 'follows_path',
'uses' => 'FollowsController@store'
]);

Route::delete('/follows/{id}', [
'as' => 'follow_path',
'uses' => 'FollowsController@destroy'
]);

/*
 * Password Resets
*/
Route::get('password/remind', 'RemindersController@getRemind');
Route::post('password/remind', 'RemindersController@postRemind');
Route::get('password/reset/{token}', 'RemindersController@getReset')
	->where('token','(.*)');
	
Route::post('password/reset/{token}', 'RemindersController@postReset')
	->where('token','(.*)');
	
@include('routes_user.php');
@include('routes_blog.php');

Route::resource('subscribe', 'SubscriptionsController');

Route::get('index/{postSlug}', 'IndexController@getView');
Route::post('index/{postSlug}', 'IndexController@postView');
Route::get('/index', array('before' => 'detectLang','uses' => 'IndexController@getIndex'));

Route::get('kjv/{book}', 'BibleController@getBook');

Route::post('bible/search', 'BibleController@getSearch');
Route::get('bible/search', 'BibleController@getSearch');
Route::get('/bible', 'BibleController@index');

Route::get('/kjv/{book}/{chapter}/{verseByV?}', 'BibleController@getChapterVerses');

Route::get('{book}_{chapter}_{verseByV}', 'BibleController@getVerse');

Route::post('/kjv/{book}/{chapter}', 'BibleController@prevNextChapter');
Route::post('/kjv/verse', 'BibleController@postVerse');


Route::get('search', ['uses' => 'SearchesController@index']);
Route::get('search/data', 'SearchesController@getData');
Route::get('search/build', ['as' => 'build_search','uses' => 'SearchesController@build']);
Route::resource('search', 'SearchesController');

/*Studies start*/

Route::get('/study','StudiesController@index');
Route::get('s/',function(){
	return Redirect::to('/study');
});

Route::post('study/search/{query}', ['as' => 'go_to_study','uses' => 'StudiesController@goToStudy']);
Route::post('study/search/query', ['as' => 'post_go_to_study','uses' => 'StudiesController@goToStudy']);
Route::get('study/tag/{tag}', ['uses' => 'StudiesController@showTag']);

Route::get('study/{study}/test','TestsController@show');
Route::post('study/{study}/test','TestsController@store');

Route::get('study/{study}-{sub1?}','StudiesController@studySpace');
Route::get('study_OLD_NOT_USED/{study}-{sub1?}/{sub2?}/{sub3?}','StudiesController@show');


/*Studies end*/

include('routes_admin.php');
include('routes_directed_study.php');
include('routes_api.php');
include( base_path() . '/vendor/folklore/graphql/src/Folklore/GraphQL/routes.php');

Route::get('/rss', 'RssController@getIndex');

Route::get('/index', 'CoursesController@index');

Route::get('/course/{course}/rss', 'RssController@getFeed');

Route::get('/moments/rss', function()
{	
	return redirect('course/47-moments/rss');
});


Route::get('/course/{course}-{courseTitle}', 'CoursesController@show');
Route::get('/courses', 'CoursesController@index');

Route::get('study/{studythis}','StudiesController@show')
->where('studythis','(.*)');



Route::get('{studythis}','SearchesController@findSomething')
	->where('studythis','(.*)');
