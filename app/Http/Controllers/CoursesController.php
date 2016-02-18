<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Entities\Course;
use BibleExchange\Entities\Page;
use BibleExchange\Entities\Study;
use BibleExchange\Entities\UserRepository;
use Auth, Flash, Input, Redirect, stdClass;

class CoursesController extends Controller {

    /**
     * Lesson Model
     * @var Lesson
     */
    protected $course;

    /**
     * Inject the models.
     * @param Lesson $lesson
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->currentUser = Auth::user();
        
        $page = new Page;
        $page->make(new Course);
        
        $this->page = $page;
        
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function index()
    {
        $courses = Course::where('public','1')->paginate(9);
		$page = $this->page;

		return view('courses.index',compact('courses','page'));
    }
	
	 public function show($course)
    {
        if($course->isPublic())
        {
    	return view('courses.show', compact('course'));
        }
        
        Flash::message('Could not find that course!');
        
        return Redirect::to('/courses');
        
    }
	
    public function showByUser($username, $course)
    {
    	if ($course === NULL ){return Redirect::to('/index?message=Sorry but we could not find that!');}
		
		$user = $this->userRepository->findByUsername($username);
		
    	$lessons = $course->lessons()->published()->get();
    			
    	$mode = 'all';
    
    	$collection = TRUE;
    
    	// Show the page
    	return view('users.courses.show-public', compact('course','lessons','title','mode','collection','meta','user'));
    }    
    
}
