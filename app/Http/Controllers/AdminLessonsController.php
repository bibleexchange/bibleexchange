<?php namespace BibleExchange\Http\Controllers;

class AdminLessonsController extends AdminController {

    /**
     * Post Model
     * @var Post
     */
    protected $lesson;

    /**
     * Inject the models.
     * @param Post $lesson
     */
    public function __construct(Lesson $lesson)
    {
        parent::__construct();
        $this->lesson = $lesson;
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = 'Lesson Management';

        // Grab all the lessons
        $model = $this->lesson;

        // Show the page
        return View::make('admin/resources/index', compact('model', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = 'Create a new Lesson';

        // Show the page
        return View::make('admin/lessons/create_edit', compact('title'));
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
            'title'   => 'required|min:3',
            'content' => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Create a new blog post
            $user = Auth::user();

            // Update the blog post data
            $this->lesson->title            = Input::get('title');
            $this->lesson->slug             = Str::slug(Input::get('title'));
            $this->lesson->content          = Input::get('content');
            $this->lesson->meta_title       = Input::get('meta-title');
            $this->lesson->meta_description = Input::get('meta-description');
            $this->lesson->meta_keywords    = Input::get('meta-keywords');
            $this->lesson->user_id          = $user->id;

            // Was the blog post created?
            if($this->lesson->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/lessons/' . $this->lesson->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/lessons/create')->with('error', Lang::get('admin/blogs/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/lessons/create')->withInput()->withErrors($validator);
	}

    /**
     * Display the specified resource.
     *
     * @param $lesson
     * @return Response
     */
	public function getShow($lesson)
	{
        // redirect to the frontend
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $lesson
     * @return Response
     */
	public function getEdit($lesson)
	{
        // Title
        $title = 'Update a Lesson';
		
		if($lesson->content_format == 'md')
		{
			$content_style = 'plain_text';
		} else 
		{
			$content_style = 'wysihtml5';
		}
		$form = new stdClass();
		$form->action = URL::to('admin/lessons/' . $lesson->id . '/edit');
		$form->publish = "/admin/lessons/{{$lesson->id}}/publish";
        // Show the page
        return View::make('admin/lessons/create_edit', compact('lesson', 'title','content_type_options','content_style','form'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $lesson
     * @return Response
     */
	public function postEdit($lesson)
	{

        // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3',
            'content' => 'required|min:3'
        );
        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the lesson post data
            $lesson->title            = Input::get('title');
            $lesson->slug             = Str::slug(Input::get('title'));
			$lesson->published		  = Input::get('published');
            $lesson->content          = Input::get('content');
			$lesson->content_format   = Input::get('content_format');
            $lesson->meta_title       = Input::get('meta-title');
            $lesson->meta_description = Input::get('meta-description');
            $lesson->meta_keywords    = Input::get('meta-keywords');

            // Was the lesson post updated?
            if($lesson->save())
            {
                // Redirect to the new lesson post page
                return Redirect::to('admin/lessons/' . $lesson->id . '/edit')->with('success', 'Lesson updated successfully.');
            }

            // Redirect to the lessons post management page
            return Redirect::to('admin/lessons/' . $lesson->id . '/edit')->with('error', Lang::get('admin/lessons/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/lessons/' . $lesson->id . '/edit')->withInput()->withErrors($validator);
	}

	public function getPublish($lesson)
	{

			if($lesson->published > 0)
			{
				$value = 0;
			}else{
				$value = 1;
			}
			
			$lesson->published = $value;
			$lesson->save();
            return Redirect::to('/admin/lessons#publish')->with('success', 'Lesson published.');
       
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $lesson
     * @return Response
     */
    public function getDelete($lesson)
    {
        // Title
        $title = "DANGER: Delete a Lesson?";

        // Show the page
        return View::make('admin/lessons/delete', compact('lesson', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $lesson
     * @return Response
     */
    public function postDelete($lesson)
    {
        // Declare the rules for the form validation
        $rules = array(
            'id' => 'required|integer'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            $id = $lesson->id;
            $lesson->delete();

            // Was the blog post deleted?
            $lesson = Lesson::find($id);
            if(empty($lesson))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/lessons')->with('success', Lang::get('admin/blogs/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        return Redirect::to('admin/lessons')->with('error', Lang::get('admin/blogs/messages.delete.error'));
    }

    /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
     public function getData()
    {
		$entryTable = 'lessons';
		$entryModel = 'Lesson';
		$selection = [$entryTable.'.id', $entryTable.'.title', 'users.username', $entryTable.'.content_format',$entryTable.'.published',$entryTable.'.updated_at'];
		
		$entries = $entryModel::leftJoin('users',$entryTable.'.user_id','=','users.id')->select($selection);
		
        return Datatables::of($entries)
		
		
        ->add_column('actions', '<a href="{{{ URL::to(\'admin/'.$entryTable.'/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">edit</a>

                                <a href="{{{ URL::to(\'admin/'.$entryTable.'/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger">delete</a>
								
								<a href="{{{ URL::to(\'admin/'.$entryTable.'/\' . $id . \'/publish\' ) }}}" class="btn btn-xs btn-success">publish/unpublish</a>
            ')

        ->remove_column('id')

        ->make();
    }
	//
	public function getTemp(){
	
	$array = Course::all();
	
	foreach($array as $a){     

		$a->slug = Str::slug($a->title);
		$a->save();
	}
	
	}
	
}