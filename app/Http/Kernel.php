<?php namespace BibleExperience\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'BibleExperience\Http\Middleware\VerifyCsrfToken',
		'Barryvdh\Cors\HandleCors',
		
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => \BibleExperience\Http\Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'auth.simple' => \BibleExperience\Http\Middleware\AuthSimple::class,
		'auth.viewer' => \BibleExperience\Http\Middleware\AuthenticateViewer::class,
		'guest' => \BibleExperience\Http\Middleware\RedirectIfAuthenticated::class,
		'registration.status' => \BibleExperience\Http\Middleware\RegistrationStatus::class,
		'auth.statement' => \BibleExperience\Http\Middleware\AuthStatement::class,
		'auth.super' => \BibleExperience\Http\Middleware\AuthSuper::class,
		'auth.lrs' => \BibleExperience\Http\Middleware\AuthLrs::class,
		'edit.lrs' => \BibleExperience\Http\Middleware\EditLrs::class,
		'create.lrs' => \BibleExperience\Http\Middleware\CreateLrs::class
	];

}

/*
CREATE THESE MIDLEWARE:


'BibleExperience\Http\Middleware\SetApiHeaders',


App::after(function($request, $response) {
  $response->headers->set('X-Experience-API-Version', '1.0.1');

  if (isset($_SERVER['HTTP_ORIGIN'])) {
    $response->headers->set('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN']);
  }
});


//////////////////////////////////////////////////////////////////////////////////////////////////


'auth.admin' => 'BibleExperience\Http\Middleware\AuthAdmin',

'user.delete' => 'BibleExperience\Http\Middleware\UserDelete'



*/


/*

use \app\locker\statements\xAPIValidation as XApiValidator;
use \BibleExperience\Helpers\Exceptions as Exceptions;
use \BibleExperience\Helpers\Helpers as Helpers;




// Checks for LRS admin.
Route::filter('auth.admin', function( $route, $request ){

  $lrs      = Lrs::find( $route->parameter('lrs') );
  $user     = Auth::user()->id;
  $is_admin = false;
  foreach( $lrs->members as $u ){
    //is the user on the LRS user list with role admin?
    if($u['user'] == $user && $u['role'] == 'admin'){
      $is_admin = true;
    }
  }
  if( !$is_admin ){
    return Redirect::to('/');
  }

});

// Checks for LRS access.
Route::filter('auth.lrs', function( $route, $request ){
  //check to see if lrs id exists?
  $lrs  = Lrs::find( $route->parameter('id') );
  //if not, let's try the lrs parameter
  if( !$lrs ){
    $lrs  = Lrs::find( $route->parameter('lrs') );
  }
  $user = \Auth::user();

  if( $lrs ){
    //get all users will access to the lrs
    foreach( $lrs->members as $u ){
      $get_users[] = $u['_id'];
    }
    //check current user is in the list of allowed users, or is super admin
    if( !in_array($user->id, $get_users) && $user->role != 'super' ){
      return Redirect::to('/');
    }

  }else{
    return Redirect::to('/');
  }

});

// Checks for LRS edit access.
Route::filter('edit.lrs', function( $route, $request ){

  //check to see if lrs id exists?
  $lrs  = Lrs::find( $route->parameter('id') );
  //if not, let's try the lrs parameter
  if( !$lrs ){
    $lrs  = Lrs::find( $route->parameter('lrs') );
  }

  $user = \Auth::user();

  if( $lrs ){

    //get all users with admin access to the lrs
    foreach( $lrs->members as $u ){
      if( $u['role'] == 'admin' ){
        $get_users[] = $u['_id'];
      }
    }

    //check current user is in the list of allowed users or is super
    if( !in_array($user->id, $get_users) && $user->role != 'super' ){
      return Redirect::to('/');
    }

  }else{
    return Redirect::to('/');
  }

});

// Checks for LRS creation access.
Route::filter('create.lrs', function( $route, $request ){

  if( !Auth::user()->can('CREATE_LRS') ){
    return Redirect::to('/');
  }

});

/*
|---------------------------------------------------------------------------
| Check the person deleting a user account, is allowed to.
|
| User's can delete their own account as can super admins
|---------------------------------------------------------------------------
*/
/*
Route::filter('user.delete', function( $route, $request ){
  $user = $route->parameter('users');
  if( \Auth::user()->id != $user && !\BibleExperience\Helpers\Access::isRole('super') ){
    return Redirect::to('/');
  }
});

*/
