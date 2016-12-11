<?php namespace BibleExperience\Http\Controllers\Auth;

use BibleExperience\Http\Controllers\Controller;
use BibleExperience\User;
use Auth, Redirect;
use Auth0\Login\Contract\Auth0UserRepository;

class AuthController extends Controller {

    /**
     * @var Auth0UserRepository
     */
    protected $userRepository;

    public function __construct(Auth0UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function afterCallback() {
	return \Redirect::to("http://localhost:3000/set-jwt?token=" . \Session::get('jwt_token'));
	//return view('jwt');
    }

  public function spa() {
	return view('spa');
  }

  public function logout() {
        \Auth::logout();
        return  \Redirect::intended('/');
  }

    public function dump() {
        dd(\Auth::user()->getUserInfo());
    }

    public function api() {
        return response()->json(['status' => 'pong!']);
    }


}
