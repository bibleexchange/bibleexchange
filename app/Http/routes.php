<?php
/*
\Auth::logout();
$user = \BibleExperience\User::find(1);
$user->setPassword('me');
$user->save();
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');

Route::get('graphiql',function(){
	return View::make('graphiql', array('name' => 'Taylor'));
});


/*
FROM LARAVEL LOCKER
*/

App::singleton('oauth2', function() {
    $storage = new OAuth2\Storage\Mongo(App::make('db')->getMongoDB());
    $server = new OAuth2\Server($storage);
    $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
    return $server;
});

Route::get('/','RootController@index');

/*
|------------------------------------------------------------------
| Login
|------------------------------------------------------------------
*/
Route::get('login', array(
  'uses'   => 'LoginController@create',
  'as'     => 'login.create'
));

Route::post('login', 'LoginController@login');

Route::get('logout', array(
  'uses' => 'LoginController@destroy',
  'as'   => 'logout'
));

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
| Site (this is for super admin users only)
|------------------------------------------------------------------
*/
Route::get('site', array(
  'as'   => 'site.index',
  'uses' => 'SiteController@index',
));
Route::get('site/settings', array(
  'uses' => 'SiteController@settings',
));
Route::get('site/apps', array(
  'uses' => 'SiteController@apps',
));
Route::get('site/stats', array(
  'uses' => 'SiteController@getStats',
));
Route::get('site/graphdata', array(
  'uses' => 'SiteController@getGraphData',
));
Route::get('site/lrs', array(
  'uses' => 'SiteController@lrs',
));
Route::get('site/users', array(
  'uses' => 'SiteController@users',
));
Route::get('site/invite', array(
  'uses' => 'SiteController@inviteUsersForm',
  'as'   => 'site.invite'
));
Route::post('site/invite', array(
  'uses' => 'SiteController@inviteUsers',
));
Route::get('site/plugins', array(
  'uses' => 'PluginController@index',
));
Route::resource('site', 'SiteController');
Route::put('site/users/verify/{id}', array(
  'uses' => 'SiteController@verifyUser',
  'as'   => 'user.verify'
));

/*
|------------------------------------------------------------------
| Lrs
|------------------------------------------------------------------
*/
Route::get('lrs/{id}/statements', array(
  'uses' => 'LrsController@statements',
));
Route::get('lrs/{id}/users', array(
  'uses' => 'LrsController@users',
));
Route::get('lrs/{id}/stats/{segment?}', array(
  'uses' => 'LrsController@getStats',
));
Route::get('lrs/{id}/graphdata', array(
  'uses' => 'LrsController@getGraphData',
));
Route::put('lrs/{id}/users/remove', array(
  'uses' => 'LrsController@usersRemove',
  'as'   => 'lrs.remove'
));
Route::put('lrs/{id}/users/{user}/changeRole/{role}', array(
  'uses' => 'LrsController@changeRole',
  'as'   => 'lrs.changeRole'
));
Route::get('lrs/{id}/users/invite', array(
  'uses' => 'LrsController@inviteUsersForm',
));
Route::get('lrs/{id}/api', array(
  'uses' => 'LrsController@api',
));

Route::resource('lrs', 'LrsController');

/*
|------------------------------------------------------------------
| Exporting
|------------------------------------------------------------------
*/

// Pages.
Route::get('lrs/{id}/exporting', array(
  'uses' => 'ExportingController@index',
));

/*
|------------------------------------------------------------------
| Lrs client
|------------------------------------------------------------------
*/
Route::get('lrs/{id}/client/manage', array(
  'before' => 'auth',
  'uses' => 'ClientController@manage',
  'as' => 'client.manage'
));

Route::delete('lrs/{lrs_id}/client/{id}/destroy', array(
  'before' => 'auth',
  'uses' => 'ClientController@destroy',
  'as' => 'client.destroy'
));

Route::get('lrs/{lrs_id}/client/{id}/edit', array(
  'before' => 'auth',
  'uses' => 'ClientController@edit',
  'as' => 'client.edit'
));

Route::post('lrs/{id}/client/create', array(
  'before' => ['auth', 'csrf'],
  'uses' => 'ClientController@create',
  'as' => 'client.create'
));

Route::put('lrs/{lrs_id}/client/{id}/update', array(
  'before' => ['auth', 'csrf'],
  'uses' => 'ClientController@update',
  'as' => 'client.update'
));

/*
|------------------------------------------------------------------
| Reporting
|------------------------------------------------------------------
*/

//index and create pages
Route::get('lrs/{id}/reporting', array(
  'uses' => 'ReportingController@index',
  'as' => 'reporting.index'
));
Route::get('lrs/{id}/reporting/{report_id}/statements', array(
  'uses' => 'ReportingController@statements',
));
Route::get('lrs/{id}/reporting/typeahead/{segment}/{query}', array(
  'uses' => 'ReportingController@typeahead',
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

/*
|------------------------------------------------------------------
| Statements
|------------------------------------------------------------------
*/
Route::get('lrs/{id}/statements/generator', 'StatementController@create');
Route::get('lrs/{id}/statements/explorer/{extra?}', 'ExplorerController@explore')
->where(array('extra' => '.*'));
Route::get('lrs/{id}/statements/{extra}', 'ExplorerController@filter')
->where(array('extra' => '.*'));

Route::resource('statements', 'StatementController');

//temp for people running the dev version pre v1.0 to migrate statements
//can only be run by super admins.
Route::get('migrate', array(
  'as'     => 'users.addpassword',
  'before' => 'auth.super',
  'uses'   => 'MigrateController@runMigration'
));
Route::post('migrate/{id}', array(
  'before' => 'auth.super',
  'uses'   => 'MigrateController@convertStatements'
));

/*
|------------------------------------------------------------------
| Information pages e.g. terms, privacy
|------------------------------------------------------------------
*/

Route::get('terms', function(){
  return View::make('partials.pages.terms');
});
//tools
Route::get('tools', array(function(){
  return View::make('partials.pages.tools', array('tools' => true));
}));
Route::get('help', array(function(){
  return View::make('partials.pages.help', array('help' => true));
}));
Route::get('about', array(function(){
  return View::make('partials.pages.about');
}));

/*
|------------------------------------------------------------------
| Statement API
|------------------------------------------------------------------
*/

Route::get('data/xAPI/about', function() {
  return Response::json([
    'X-Experience-API-Version'=>Config::get('xapi.using_version'),
    'version' => [\Config::get('xapi.using_version')]
  ]);
});

Route::group( array('prefix' => 'data/xAPI', 'before'=>'auth.statement'), function(){

  Config::set('xapi.using_version', '1.0.1');

  // Statement API.
  Route::get('statements/grouped', array(
    'uses' => 'Controllers\xAPI\StatementController@grouped',
  ));
  Route::any('statements', [
    'uses' => 'Controllers\xAPI\StatementController@selectMethod',
    'as' => 'xapi.statement'
  ]);

  // Agent API.
  Route::any('agents/profile', [
    'uses' => 'Controllers\xAPI\AgentController@selectMethod'
  ]);
  Route::get('agents', [
    'uses' => 'Controllers\xAPI\AgentController@search'
  ]);

  // Activiy API.
  Route::any('activities/profile', [
    'uses' => 'Controllers\xAPI\ActivityController@selectMethod'
  ]);
  Route::get('activities', [
    'uses' => 'Controllers\xAPI\ActivityController@full'
  ]);

  // State API.
  Route::any('activities/state', [
    'uses' => 'Controllers\xAPI\StateController@selectMethod'
  ]);

  //Basic Request API
  Route::post('Basic/request', array(
    'uses' => 'Controllers\xAPI\BasicRequestController@store',
  ));

});

Route::group(['prefix' => 'api/v2', 'middleware' => 'auth.basic','auth.statement'], function () {
  Route::get('statements/insert', ['uses' => 'API\Statements@insert']);
  Route::get('statements/void', ['uses' => 'API\Statements@void']);
});

/*
|------------------------------------------------------------------
| Learning Locker RESTful API
|------------------------------------------------------------------
*/

Route::group( array('prefix' => 'api/v1','middleware'=>'auth.basic'), function(){

  Config::set('api.using_version', 'v1');

  Route::get('/', function() {
    return Response::json( array('version' => Config::get('api.using_version')));
  });
  
  Route::get('query/analytics','Api\Analytics@index');
  Route::get('query/statements', 'Api\Statements@index');

  Route::resource('exports', 'Api\Exports');
  Route::get('exports/{id}/show','Api\Exports@showJson');
  Route::get('exports/{id}/show/csv','Api\Exports@showCsv');

  // Adds routes for reports.
  Route::resource('reports', 'Api\Reports');
  Route::get('reports/{id}/run', 'Api\Reports@run');
  Route::get('reports/{id}/graph', 'Api\Reports@graph');

  // Adds routes for statements.
  Route::get('statements/where','Api\Statements@where');
  Route::get('statements/aggregate','Api\Statements@aggregate');
  Route::get('statements/aggregate/time', 'Api\Statements@aggregateTime');
  Route::get('statements/aggregate/object','Api\Statements@aggregateObject');

});

/*
|----------------------------------------------------------------------
| oAuth handling
|----------------------------------------------------------------------
*/
Route::post('oauth/access_token', function() {
  $bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
  $bridgedResponse = new OAuth2\HttpFoundationBridge\Response();
  $bridgedResponse = App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);
  return $bridgedResponse;
});

//Add OPTIONS routes for all defined xAPI and api routes
foreach( Route::getRoutes()->getIterator() as $route  ){
  if( $route->getPrefix() === 'data/xAPI' || $route->getPrefix() === 'api/v1' ){
    Route::options($route->getUri(), 'API\Base@CORSOptions');
  }
}
