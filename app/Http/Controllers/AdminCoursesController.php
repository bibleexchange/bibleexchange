<?php namespace BibleExchange\Http\Controllers;

class AdminCoursesController extends AdminController {


    /**
     * Course Model
     * @var Course
     */
    protected $course;

    /**
     * Inject the models.
     * @param Course $course
     */
    public function __construct(Course $course)
    {
        parent::__construct();
        $this->course = $course;
    }

    /**
     * Show a list of all the blog courses.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('Courses Management');

        // Grab all the blog courses
        $courses = $this->course;

        // Show the page
        return View::make('admin/exchangeindex', compact('courses', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = 'Create a New Course';

        // Show the page
        return View::make('admin/exchangecreate_edit', compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
        // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog course data
            $this->course->title            = Input::get('title');
            $this->course->subtitle         = Input::get('subtitle');
            $this->course->year          	  = Input::get('year');
            $this->course->shortname        = Input::get('shortname');
            $this->course->acceptingEnroll  = Input::get('acceptingEnroll');
            $this->course->webReady    	  = Input::get('webReady');
			$this->course->public    	  	  = Input::get('public');

            // Was the blog course created?
            if($this->course->save())
            {
                // Redirect to the new blog course page
                return Redirect::to('admin/exchange' . $this->course->id . '/edit')->with('success', 'Course was created successfully.');
            }

            // Redirect to the blog course create page
            return Redirect::to('admin/exchangecreate')->with('error', Lang::get('admin/blogs/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/exchangecreate')->withInput()->withErrors($validator);
	}

    /**
     * Display the specified resource.
     *
     * @param $course
     * @return Response
     */
	public function getShow($course)
	{
        // redirect to the frontend
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $course
     * @return Response
     */
	public function getEdit($course)
	{
        // Title
        $title = 'Update Course';

        // Show the page
        return View::make('admin/exchangecreate_edit', compact('course', 'title'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $course
     * @return Response
     */
	public function postEdit($course)
	{
        // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog course data
            $course->title            = Input::get('title');
            $course->subtitle         = Input::get('subtitle');
            $course->year          	  = Input::get('year');
            $course->shortname        = Input::get('shortname');
            $course->acceptingEnroll  = Input::get('acceptingEnroll');
            $course->webReady    	  = Input::get('webReady');
			$course->public    	  	  = Input::get('public');
			
            // Was the course updated?
            if($course->save())
            {
                // Redirect to the new course page
                return Redirect::to('admin/exchange' . $course->id . '/edit')->with('success', 'Course updated successfully.');
            }

            // Redirect to the courses management page
            return Redirect::to('admin/blogs/' . $course->id . '/edit')->with('error', Lang::get('admin/blogs/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/blogs/' . $course->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $course
     * @return Response
     */
    public function getDelete($course)
    {
        // Title
        $title = 'Are you sure you want to DELETE this Course?';

        // Show the page
        return View::make('admin/exchangedelete', compact('course', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $course
     * @return Response
     */
    public function postDelete($course)
    {
dd($course);
	    // Declare the rules for the form validation
        $rules = array(
            'id' => 'required|integer'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            $id = $course->id;
            $course->delete();

            // Was the blog post deleted?
            $course = Course::find($id);
            if(empty($course))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/courses')->with('success', Lang::get('admin/blogs/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        return Redirect::to('admin/courses')->with('error', Lang::get('admin/blogs/messages.delete.error'));
    }

    /**
     * Show a list of all the blog courses formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
		
	   $courses = Course::select(array('id','title','subtitle','acceptingEnroll','webReady','public','created_at','updated_at'));
		
        return Datatables::of($courses)

        ->add_column('posts', "{{DB::table('posts')
            ->join('course_post', 'posts.id', '=', 'course_post.post_id')
			->join('courses', 'course_post.course_id', '=', 'courses.id')
            ->select('posts.title')
			->where('course_post.course_id','=',\$id)
			->orderBy ('posts.title','ASC')
            ->count() }}",9)

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/exchange\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/exchange\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')

        ->make();
    }

}