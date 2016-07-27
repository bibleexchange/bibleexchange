<?php namespace BibleExperience\Http\Controllers;

use BibleExperience\Repository\User\UserRepository as User;
use BibleExperience\Repository\Lrs\Repository as Lrs;
use BibleExperience\Locker\Helpers\User as UserHelpers;

use BibleExperience\NoteRepository;
use BibleExperience\CrossReference;
use Auth;

class UserController extends BaseController {

  protected $user, $lrs, $noteRepository;
	
  /**
   * Construct
   *
   * @param User $user
   */
  public function __construct(User $user, Lrs $lrs,NoteRepository $noteRepository){
    $this->user = $user;
    $this->lrs = $lrs;
    $this->logged_in_user = \Auth::user();
	
	$this->middleware('auth', ['except' => ['verifyEmail']]);
    //$this->middleware('csrf', ['only' => ['update','updateRole', 'destroy']]);
    $this->middleware('user.delete', ['only' => 'destroy']);
    $this->middleware('auth.super', ['only' => ['updateRole','index']]);
  }

  /**
   * Display a listing of users.
   * @return View
   */
  public function index() {
    return \View::make('index', ['users' => $this->user->all()]);
	
	/*
	
	    	if($this->currentUser->isSetup() && $this->currentUser->isConfirmed()){
			
    		$notifications = new \BibleExperience\NotificationFetcher($this->currentUser);
			$notifications = $notifications->onlyUnread()->fetch();
    		$notes = $this->noteRepository->getFeedForUser($this->currentUser);
    		$notes_per_page = 5;
    		$data_path = '/user/notes/data';
    		
    		return view('home.home',compact('notifications','notes','notes_per_page','data_path'));
    	}
    	return view('home.index');
	
	*/
	
  }

  /**
   * Show the form for creating a new resource.
   * @return View
   */
  public function create() {	  
    return \View::make('register.index');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return View
   */
  public function edit($id) {
	  
    $opts = ['user' => \Auth::user()];

    return \View::make('partials.users.edit')
      ->with('user', $this->user->find($id))
      ->with('list', \Auth::user()->lrss);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return View
   */
  public function update( $id ){
    $data = \Input::all();

    //if email being changed, verify new one, otherwise ignore
    if( $data['email'] != Auth::user()->email ){
      $rules['email'] = 'required|email|unique:users';
    }
    $rules['name']  = 'required';       
    $validator = Validator::make($data, $rules);
    if ($validator->fails()) return Redirect::back()->withErrors($validator);
  
    // Update the user
    $s = $this->user->update($id, $data);

    if($s){
      return Redirect::back()->with('success', Lang::get('users.updated'));
    }

    return Redirect::back()
      ->withInput()
      ->with('error', Lang::get('users.updated_error'));

	  
	  /*
	  
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
        
	  
	  */
	  
  }

  /**
   * Update the user's role.
   *
   * @param  int  $id
   * @return View
   */
  public function updateRole( $id, $role ){
    $s = $this->user->updateRole($id, $role);
    return Response::json($s);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return View
   */
  public function destroy( $id ){
    //delete
    $this->user->delete( $id );
    return Redirect::back()->with('success', Lang::get('users.deleted'));
  }

  public function resetPassword($id) {
    $user = $this->user->find($id);
    $token = UserHelpers::setEmailToken($user, $user->email);
    return \URL::route('email.invite', [$token]);
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
	
	
}