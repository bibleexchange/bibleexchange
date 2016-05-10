<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests\UpdateProfileRequest;
use BibleExchange\Commands\UpdateProfileCommand;
use Auth,Input,Flash, Redirect, Evernote;
use BibleExchange\Entities\User;

class UserSettingsController extends Controller {
	
	private $profileForm;
	
	function __construct()
	{
		
		$this->middleware('auth');
		
		$this->currentUser = Auth::user();
		
	}
	
	public function index()
    {    	
    	return view('home.settings.index');
    }
	
	public function store(UpdateProfileRequest $request)
	{		
		$input = Input::all();
		$profile_image = $input['profile_image'];
		
		if (isset($input['profile_image'])){
			
			$image = $input['profile_image'];
			
			if($_SERVER['CONTENT_LENGTH'] >= 2022645){
				Flash::error('file was too large');
				return Redirect::back();
			}
			
			$imageMade = \Photo::make($input['profile_image']->getRealPath());
			$fileName = '/images/profiles/'. Auth::user()->id . '.' . str_replace('image/','',$imageMade->mime());
			$destination = base_path().'/resources'.$fileName;
			$imageMade->save($destination);
			
			$profile_image = $fileName;
			
		}
			
		$user = $this->dispatch(new UpdateProfileCommand(
				$input['firstname'], $input['middlename'], $input['lastname'], $input['suffix'], $input['gender'], $profile_image, $input['location']
				));
		
		Flash::success('Success! Your profile has been updated.');
		
		return Redirect::to('/user/settings');
		
	}
	
	public function deleteProfileImage(){
		
		$user = Auth::user();
		$user->profile_image = null;
		$user->save();
		
		Flash::success('Your profile image has been set to Gravatar.');
		
		return Redirect::to('/user/settings');
	}
}