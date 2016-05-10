<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Entities\BibleHighlight as Highlight;
use Input, Auth, Redirect, Flash;

class UserHighlightsController extends Controller {
	
	function __construct(){
		
		$this->middleware('auth');
        
        $this->currentUser = Auth::user();
		
	}

    public function index()
    {
		//return  view('home.bookmarks.index');
    }
	
    public function store()
    {	  	

    	$highlight = Highlight::make(Input::get('bible_verse_id'),Auth::user()->id,Input::get('color'));
		$highlight->save();
		
		Flash::message('Your highlight was saved');
		
		return Redirect::back();
    }
	
	 public function data()
    {
		return $this->currentUser->highlights;
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /examples/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($highlight)
	{
		$user = Auth::user();
	
		if ($highlight->user_id === $user->id){
				
			Highlight::destroy($hightlight->id);
			\Flash::success('Your highlight has been deleted!');
	
		}else{
	
			\Flash::warning('You don\'t have permission to delete this!');
	
		}
	
		return Redirect::back();
	}
	
}
