<?php namespace BibleExperience\Http\Controllers\Api;

use BibleExperience\User;
use BibleExperience\Transformers\UserTransformer;
use Input, Auth, Str;

class ApiUsersController extends ApiController {
	/**
	 * 
	 *
	 * @var /Entities/Transformers/StudyTransformer
	 */
	protected $UserTransformer;
	
	function __construct(UserTransformer $UserTransformer){
		
		$this->UserTransformer = $UserTransformer;

	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$limit = Input::get('limit') ?: 5;
		
		if ($limit > 15){$limit = 15;}
		$user = new User;
		$users = $user->paginate($limit);
		
		return $this->respondWithPagination($users,
				[
				'data'=>$this->UserTransformer->transformCollection($users->all()),
				]
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function currentUser()
	{		
		if( Auth::check() ){
			
			$user = Auth::user();
			
			return $this->respond([
					'data'=>$this->UserTransformer->transform($user)
			]);
			
		}
		
		return $this->respondNotFound('You are not logged in.');
		
	}
	
}
