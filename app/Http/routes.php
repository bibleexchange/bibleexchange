<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//Auth::logout();
/*
$credentials = ['email'=>'sgrjr@deliverance.me','password'=>'happy'];
		
if ( ! $token = JWTAuth::attempt($credentials)) {
   abort(403, 'Not valid credentials');
}
		
$user = JWTAuth::toUser($token);
dd(JWTAuth::getToken());
dd();
*/

//$v = new BibleExchange\Entities\Viewer(1);
//dd($v);


Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('graphiql',function(){
	return View::make('graphiql', array('name' => 'Taylor'));
});