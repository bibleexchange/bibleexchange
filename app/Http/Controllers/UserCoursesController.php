<?php namespace BibleExperience\Http\Controllers;

use BibleExperience\Http\Requests;
use BibleExperience\Http\Requests\CreateCourseRequest;
use BibleExperience\Commands\CreateCourseCommand;
use BibleExperience\Http\Controllers\Controller;
use Input, Auth, Str, Flash, Redirect;
use BibleExperience\Entities\UserRepository;
use Illuminate\Http\Request;

class UserCoursesController extends Controller {
	
	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}
	
	public function index($username)
	{
		$user = $this->userRepository->findByUsername($username);
	
		$courses = $user->courses()->public()->paginate(9);
	
		return view('users.courses.index-public',compact('courses','user'));
	}

}
