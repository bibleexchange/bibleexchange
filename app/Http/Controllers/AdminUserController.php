<?php namespace BibleExchange\Http\Controllers;

class AdminUserController extends UserController {

	public function index() {		
		
		$resourceName = 'Users';
		$resourceName1 = 'users';
		$model = new User;
		$Resource = $model->allPerPage(15,'lastname');
		
		return View::make('crud.users.index',[
			'user'=>$this->user,
			'Resource'=>$Resource,
			'resourceName'=>$resourceName,
			'resourceName1'=>$resourceName1,
			'filterName'=>NULL,
			'filterList'=>[NULL],
			'pageTitle'=>'Veiw All Users'
		]);
	
	}

	public function create()
	{
		//
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find($id);
		$user->delete();
		return Redirect::route('admin.users.index')->with('message','User '.$user->id.' Deleted');

	}



public function attach($userId)
	{
		
		$resourceName = 'Role';
		$resourceName1 = 'roles';		
		$Resource = Role::all();
		$User =  User::find($userId);
       
	   return View::make('crud.users.attach')
            ->with('row',$User)
			->with('user',$User)
			->with('Chapters',Role::lists('name'))
			->with('pageTitle',$User->firstname.' '.$User->lastname.' | Attach | DBI')
			->with('Resource',$Resource)
			->with('resourceName',$resourceName)
			->with('resourceName1',$resourceName1)
			->with('filterName',NULL)
			->with('filterList',[NULL]);
		
	}
	
	public function postAttach()
	{
		$entry = User::find(Input::get('user'));
		$entryToAttach = Role::find(Input::get('role'));
		$entry->roles()->attach($entryToAttach);
		
		return Redirect::to('/admin/users')->withMessage('Successfully added new role');
	}
	
	public function getDetach($user, $role)
	{
		$user = User::find($user);
		$role = Role::find($role);
		$user->roles()->detach($role);
		
		return Redirect::back()->withMessage('Role Deleted!');
	}
}