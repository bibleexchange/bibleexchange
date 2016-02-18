<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Commands\AmenObjectCommand;
use BibleExchange\Commands\UnamenObjectCommand;
use Input,Auth, Flash, Redirect;

class AmensController extends Controller {
	
	public function __construct(){
		
		$this->middleware('auth');
		
		$this->currentUser = Auth::user();
		
	}
	
	/**
	 * Amen an Object
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$amen = $this->dispatch(new AmenObjectCommand(Auth::user(), Input::get('amenable_type'), Input::get('amenable_id')));
        
         Flash::success('Amen!');
        
        return Redirect::back();       

	}

    /**
     * Unamen an Object
     *
     * @param $userIdToUnfollow
     * @internal param int $id
     * @return Response
     */
	public function destroy()
	{

        $this->dispatch(new UnamenObjectCommand(Auth::user(), Input::get('amenable_type'), Input::get('amenable_id')));

        Flash::success('You have removed your amen.');

        return Redirect::back();
	}


}
