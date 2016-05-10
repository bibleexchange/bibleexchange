<?php namespace BibleExchange\Http\Controllers;

class AdminCommentsController extends AdminController
{

    /**
     * Comment Model
     * @var Comment
     */
    protected $comment;

    /**
     * Inject the models.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        parent::__construct();
        $this->comment = $comment;
    }

    /**
     * Show a list of all the comment lessons.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = 'Lessons Comment Manager';

        // Grab all the comment lessons
        $comments = $this->comment;

        // Show the page
        return View::make('admin/comments/index', compact('comments', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $comment
     * @return Response
     */
	public function getEdit($comment)
	{
        // Title
        $title = Lang::get('admin/comments/title.comment_update');

        // Show the page
        return View::make('admin/comments/edit', compact('comment', 'title'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $comment
     * @return Response
     */
	public function postEdit($comment)
	{
        // Declare the rules for the form validation
        $rules = array(
            'content' => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the comment lesson data
            $comment->content = Input::get('content');

            // Was the comment lesson updated?
            if($comment->save())
            {
                // Redirect to the new comment lesson page
                return Redirect::to('admin/comments/' . $comment->id . '/edit')->with('success', Lang::get('admin/comments/messages.update.success'));
            }

            // Redirect to the comments lesson management page
            return Redirect::to('admin/comments/' . $comment->id . '/edit')->with('error', Lang::get('admin/comments/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/comments/' . $comment->id . '/edit')->withInput()->withErrors($validator);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $comment
     * @return Response
     */
	public function getDelete($comment)
	{
        // Title
        $title = Lang::get('admin/comments/title.comment_delete');

        // Show the page
        return View::make('admin/comments/delete', compact('comment', 'title'));
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $comment
     * @return Response
     */
	public function postDelete($comment)
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
            $id = $comment->id;
            $comment->delete();

            // Was the comment lesson deleted?
            $comment = Comment::find($id);
            if(empty($comment))
            {
                // Redirect to the comment lessons management page
                return Redirect::to('admin/comments')->with('success', Lang::get('admin/comments/messages.delete.success'));
            }
        }
        // There was a problem deleting the comment lesson
        return Redirect::to('admin/comments')->with('error', Lang::get('admin/comments/messages.delete.error'));
	}

    /**
     * Show a list of all the comments formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $comments = Comment::leftjoin('lessons', 'lessons.id', '=', 'comments.lesson_id')
                        ->leftjoin('users', 'users.id', '=','comments.user_id' )
                        ->select(array('comments.id as id', 'lessons.id as lessonid','users.id as userid', 'comments.content', 'lessons.title as lesson_name', 'users.username as lessoner_name', 'comments.created_at'));

        return Datatables::of($comments)

        ->edit_column('content', '<a href="{{{ URL::to(\'admin/comments/\'. $id .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($content, 40, \'...\') }}}</a>')

        ->edit_column('lesson_name', '<a href="{{{ URL::to(\'admin/lessons/\'. $lessonid .\'/edit\') }}}" class="iframe cboxElement">{{{ Str::limit($lesson_name, 40, \'...\') }}}</a>')

        ->edit_column('lessoner_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="iframe cboxElement">{{{ $lessoner_name }}}</a>')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/comments/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-default btn-xs">{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/comments/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

        ->remove_column('id')
        ->remove_column('lessonid')
        ->remove_column('userid')

        ->make();
    }

}
