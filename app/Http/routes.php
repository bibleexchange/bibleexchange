<?php

/*
|--------------------------------------------------------------------------
| General Application Routes
|--------------------------------------------------------------------------
|
*/

\Auth0::onLogin(function($auth0) {

    // See if the user exists
    $user = BibleExperience\User::where("auth0id", $auth0->user_id)->first();
    if ($user === null) {
	// If not, create one
	$user = new BibleExperience\User();
	$user->verified = 'yes';
	$user->email = $auth0->email;
	$user->auth0id = $auth0->user_id;
	$user->nickname = $auth0->nickname;
	$user->name = $auth0->name;
	$user->save();
     }
	$token = \JWTAuth::fromUser($user);
	session(['jwt_token'=> $token]);
	return $user;
});


Route::get('/', 'Auth\AuthController@afterCallback');

include(app_path().'/Http/routes/test.php');

/*
|--------------------------------------------------------------------------
| Graphiql
|--------------------------------------------------------------------------
|
*/
Route::get('graphiql',['middleware'=>[],function(){
  return View::make('graphiql', array('name' => 'Taylor'));
}]);

/*
|------------------------------------------------------------------
| Site (this is for super admin users only)
|------------------------------------------------------------------
*/
include(app_path().'/Http/routes/site.php');

/*
|------------------------------------------------------------------
| Lrs & Lrs Client & Exporting & Reporting
|------------------------------------------------------------------
*/
include(app_path().'/Http/routes/lrs.php');

/*
|------------------------------------------------------------------
| Statements
|------------------------------------------------------------------
*/
include(app_path().'/Http/routes/statements.php');

/*
|------------------------------------------------------------------
| Learning Locker RESTful API
|------------------------------------------------------------------
*/
include(app_path().'/Http/routes/api-v1.php');

/*
|----------------------------------------------------------------------
| Auth handling
|----------------------------------------------------------------------
*/
include(app_path().'/Http/routes/auth.php');

