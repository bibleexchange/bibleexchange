<?php

Route::group(['middleware' => ['web']], function () {
    
Route::get('/auth0/callback', '\Auth0\Login\Auth0Controller@callback');

/*
|------------------------------------------------------------------
| Login
|------------------------------------------------------------------
*/

	Route::get('/login', array(
	  'uses'   => 'LoginController@create',
	  'as'     => 'login.create'
	));

	Route::get('/logout', array(
	  'uses' => 'LoginController@destroy',
	  'as'   => 'logout'
	));

});

Route::get('/dump', ['as' => 'dump', 'uses' => 'Auth\AuthController@dump', 'middleware' => 'auth']);
Route::get('/api/ping', ['as' => 'api', 'uses' => 'Auth\AuthController@api', 'middleware' => 'auth0.jwt']);

/*
|------------------------------------------------------------------
| Register
|------------------------------------------------------------------
*/
Route::get('register', array(
  'uses'   => 'RegisterController@index',
  'as'     => 'register.index'
));
Route::post('register', array(
  'uses'   => 'RegisterController@store',
  'as'     => 'register.store'
));

/*
|------------------------------------------------------------------
| Password reset
|------------------------------------------------------------------
*/
Route::get('password/reset', array(
  'uses' => 'PasswordController@remind',
  'as'   => 'password.remind'
));
Route::post('password/reset', array(
  'uses' => 'PasswordController@request',
  'as'   => 'password.request'
));
Route::get('password/reset/{token}', array(
  'uses' => 'PasswordController@reset',
  'as'   => 'password.reset'
));
Route::post('password/reset/{token}', array(
  'uses' => 'PasswordController@postReset',
  'as'   => 'password.update'
));


/*
FROM LARAVEL LOCKER
*/
/*
App::singleton('oauth2', function() {
    $storage = new OAuth2\Storage\Mongo(App::make('db')->getMongoDB());
    $server = new OAuth2\Server($storage);
    $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
    return $server;
});
*/

/*
Route::post('oauth/access_token', function() {
  $bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
  $bridgedResponse = new OAuth2\HttpFoundationBridge\Response();
  $bridgedResponse = App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);
  return $bridgedResponse;
});
*/
//Add OPTIONS routes for all defined xAPI and api routes
/*
foreach( Route::getRoutes()->getIterator() as $route  ){
  if( $route->getPrefix() === 'data/xAPI' || $route->getPrefix() === 'api/v1' ){
    Route::options($route->getUri(), 'API\Base@CORSOptions');
  }
}
*/
/////
/*
App::singleton('oauth2', function() {
    
	$storage = new BibleExperience\OAuth2\Storage\Pdo(array('dsn' => 'mysql:dbname=dev_exchange;host=localhost', 'username' => 'root', 'password' => ''));
	$server = new BibleExperience\OAuth2\Server($storage);
	
	$server->addGrantType(new BibleExperience\OAuth2\GrantType\ClientCredentials($storage));
	$server->addGrantType(new BibleExperience\OAuth2\GrantType\UserCredentials($storage));
	
	return $server;
});
*/
/*
Route::group( array('prefix' => 'oauth','middleware'=>['auth.basic','cors']), function(){

	//Temporary Credential Request	OAuth/initiate	http://example.com/xAPI/OAuth/initiate
	Route::get('initiate','Mine\OauthController@initiate');

	//Resource Owner Authorization	OAuth/authorize	http://example.com/xAPI/OAuth/authorize
	Route::get('authorize','Mine\OauthController@authorizeIt');

	//Token Request	OAuth/token	http://example.com/xAPI/OAuth/token
	Route::post('token','Mine\OauthController@token');
});
*/

/*
|------------------------------------------------------------------
| Email verification
|------------------------------------------------------------------
*/
Route::post('email/resend', function(){
   Event::fire('user.email_resend', array(Auth::user()));
   return Redirect::back()->with('success', Lang::get('users.verify_request') );
});
Route::get('email/verify/{token}', array(
  'uses' => 'EmailController@verifyEmail',
  'as'   => 'email.verify'
));
Route::get('email/invite/{token}', array(
  'uses' => 'EmailController@inviteEmail',
  'as'   => 'email.invite'
));

/*
|------------------------------------------------------------------
| Users
|------------------------------------------------------------------
*/
Route::resource('users', 'UserController');
Route::put('users/update/password/{id}', array(
  'as'     => 'users.password',
  'before' => 'csrf',
  'uses'   => 'PasswordController@updatePassword'
));
Route::put('users/update/role/{id}/{role}', array(
  'as'     => 'users.role',
  'uses'   => 'UserController@updateRole'
));
Route::get('users/{id}/add/password', array(
  'as'     => 'users.addpassword',
  'uses'   => 'PasswordController@addPasswordForm'
));
Route::put('users/{id}/add/password', array(
  'as'     => 'users.addPassword',
  'before' => 'csrf',
  'uses'   => 'PasswordController@addPassword'
));
Route::get('users/{id}/reset/password', array(
  'as'     => 'users.resetpassword',
  'uses'   => 'UserController@resetPassword'
));


