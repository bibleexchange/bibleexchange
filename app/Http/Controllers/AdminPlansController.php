<?php namespace BibleExchange\Http\Controllers;

class AdminPlansController extends AdminController {

    /**
     * Post Model
     * @var Post
     */
    protected $plan;

    /**
     * Inject the models.
     * @param Post $plan
     */
    public function __construct(Plan $plan)
    {
        parent::__construct();
        $this->plan = $plan;

    }

    /**
     * Show a list of all the entries.
     *
     * @return View
     */
    public function index()
    {
        // Title
        $title = 'Plans Management';
		
        // Grab all the plans
        $model = $this->plan;
		
        // Show the page
        return View::make('admin/resources/index', compact('model', 'title'));
		
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        // Title
        $title = 'Create a new Lesson';
		// Mode
		$mode = 'create';
        // Show the page
        return View::make('admin/plans/create_edit', compact('title','mode'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
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
            $this->plan->title            = Input::get('title');
            $this->plan->slug             = Str::slug(Input::get('title'));
            $this->plan->content          = Input::get('content');
            $this->plan->meta_title       = Input::get('meta-title');
            $this->plan->meta_description = Input::get('meta-description');
            $this->plan->meta_keywords    = Input::get('meta-keywords');
            $this->plan->user_id          = $user->id;

            // Was the blog post created?
            if($this->plan->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/resources/' . $this->plan->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/resources/create')->with('error', Lang::get('admin/blogs/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/resources/create')->withInput()->withErrors($validator);
	}

    /**
     * Display the specified resource.
     *
     * @param $plan
     * @return Response
     */
	public function show($plan)
	{
        // redirect to the frontend
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $plan
     * @return Response
     */
	public function edit($plan)
	{
        // Title
        $title = 'Update a Plan';
		// Mode
		$mode = 'edit';
		$resource = Plan::find($plan);
		
        // Show the page
        return View::make('admin/plans/create_edit', compact('resource', 'title','mode'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $plan
     * @return Response
     */
	public function update($plan)
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
            $plan->title            = Input::get('title');
            $plan->slug             = Str::slug(Input::get('title'));
            $plan->content          = Input::get('content');
            $plan->meta_title       = Input::get('meta-title');
            $plan->meta_description = Input::get('meta-description');
            $plan->meta_keywords    = Input::get('meta-keywords');

            // Was the lesson post updated?
            if($plan->save())
            {
                // Redirect to the new lesson post page
                return Redirect::to('admin/resources/' . $plan->id . '/edit')->with('success', 'Lesson updated successfully.');
            }

            // Redirect to the resources post management page
            return Redirect::to('admin/resources/' . $plan->id . '/edit')->with('error', Lang::get('admin/resources/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/resources/' . $plan->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $plan
     * @return Response
     */
    public function delete($plan)
    {
        // Title
        $title = "DANGER: Delete a Lesson?";

        // Show the page
        return View::make('admin/resources/delete', compact('lesson', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $plan
     * @return Response
     */
    public function destroy($plan)
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
            $id = $plan->id;
            $plan->delete();

            // Was the blog post deleted?
            $plan = Lesson::find($id);
            if(empty($plan))
            {
                // Redirect to the blog posts management page
                return Redirect::to('admin/resources')->with('success', Lang::get('admin/blogs/messages.delete.success'));
            }
        }
        // There was a problem deleting the blog post
        return Redirect::to('admin/resources')->with('error', Lang::get('admin/blogs/messages.delete.error'));
    }

    /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
   public function getData()
    {
        
		$entryTable = 'plans';
		$entryModel = 'Plan';
		$selection = [$entryTable.'.id', $entryTable.'.name',$entryTable.'.amount', $entryTable.'.description', $entryTable.'.interval',$entryTable.'.features'];
		
		$entries = $entryModel::select($selection);
		
        return Datatables::of($entries)

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/'.$entryTable.'/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">edit</a>

                                <a href="{{{ URL::to(\'admin/'.$entryTable.'/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger">delete</a>
            ')

        ->remove_column('id')

        ->make();
    }
		
}