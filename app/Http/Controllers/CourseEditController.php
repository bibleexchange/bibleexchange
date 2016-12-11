<?php namespace BibleExperience\Http\Controllers;

use BibleExperience\Course;

class CourseEditController extends Controller {


    /**
     * Course Model
     * @var Course
     */
    protected $course;

    /**
     * Inject the models.
     * @param Course $course
     */
    public function __construct()
    {

    }

    /**
     * Show a list of all the blog courses.
     *
     * @return View
     */
    public function index()
    {
	//
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function edit($request_id)
	{
	$course = Course::find($request_id);	

        // Show the page
        return view('editor.index', compact('course'));
	}  

}
