<?php namespace BibleExperience\Http\Controllers;

use BibleExperience\Ez\MyForm;

class LoginController extends BaseController {

   public function __construct(){
	$this->forms = new MyForm;
	
	$this->middleware('guest', ['except' => [
		'destroy'
	]]);
		
  }
  
  /**
  * Show the form for creating a new Session
  */
  public function create(){

	$site = \BibleExperience\Site::first(); 
	$register_data = $this->forms->login();
	
	if( isset($site) ){
	  return view('system.forms.login',compact('site','register_data'));
    }else{
	  
	  return view('system.forms.login',compact('register_data'));
    }
	
  }

  public function login(){
    $creds = array(
      'email'    => Input::get('email'),
      'password' => Input::get('password')
    );

    $remember_me = Input::get('remember', 0);

    if( Auth::attempt($creds, $remember_me) ){
      return Redirect::intended('/');
    } 

    return Redirect::route('login.create')
        ->withInput()
        ->withErrors(array('There is a problem with those credentials.'));

  }

  /**
   * Logout
   **/
  public function destroy(){
	  
    \Auth::logout();
    return \Redirect::to('/');
  }

}