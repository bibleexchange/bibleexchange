<?php 

namespace BibleExperience\Http\Controllers;

use Redirect, Auth, Hash, Input;
use BibleExperience\User;

class RegistrationController extends Controller {

    public function confirmUser($confirmation_code)
    {
		$user = User::where('confirmation_code', $confirmation_code)->first();
		$user->confirmation_code = null;
		$user->verified = true;
		$user->save();

		return Redirect::to('/');		
    }
    
}
