<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Entities\User;
use BibleExchange\Entities\NoteRepository;
use BibleExchange\Entities\CrossReference;
use Auth;

class UserController extends Controller {

	protected $noteRepository;
	
    function __construct(NoteRepository $noteRepository)
    {
    	
        $this->noteRepository = $noteRepository;
        
        $this->middleware('auth');
        
        $this->currentUser = Auth::user();
   
    }
	
    public function index()
    {

    	if($this->currentUser->isSetup() && $this->currentUser->isConfirmed()){
			
    		$notifications = new \BibleExchange\Entities\NotificationFetcher($this->currentUser);
			$notifications = $notifications->onlyUnread()->fetch();
    		$notes = $this->noteRepository->getFeedForUser($this->currentUser);
    		$notes_per_page = 5;
    		$data_path = '/user/notes/data';
    		
    		return view('home.home',compact('notifications','notes','notes_per_page','data_path'));
    	}
    	return view('home.index');
    }
	
	public function getNotes(){

    	$notes = $this->noteRepository->getFeedForUser($this->currentUser);
    	$notes_per_page = 5;
    	$data_path = '/user/notes/data';
    	return view('notes.index', compact('notes','notes_per_page','data_path'));
 
    }
	
    public function getFeed()
    {
    	$notes = $this->noteRepository->getFeedForUser($this->currentUser);
    	$notes_per_page = 5;
    	$data_path = '/user/notes/data';
    	return view('notes.index', compact('notes','notes_per_page','data_path'));
    }
    
    /**
     * Edits a user
     *
     */
    public function store($user)
    {
            $oldUser = clone $user;
            $user->username = Input::get( 'username' );
            $user->email = Input::get( 'email' );

            $password = Input::get( 'password' );
            $passwordConfirmation = Input::get( 'password_confirmation' );

            if(!empty($password)) {
                if($password === $passwordConfirmation) {
                    $user->password = $password;
                    $user->password_confirmation = $passwordConfirmation;
                } else {
                    return Redirect::to('users')->with('error', Lang::get('admin/users/messages.password_does_not_match'));
                }
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }
       
            return Redirect::to('user')
                ->with( 'success', 'Account updated');
        
    }
    
}
