<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Requests\CreateCourseRequest;
use BibleExchange\Commands\CreateCourseCommand;
use BibleExchange\Http\Controllers\Controller;
use Input, Auth, Str, Flash, Redirect;
use BibleExchange\Entities\UserRepository;
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
