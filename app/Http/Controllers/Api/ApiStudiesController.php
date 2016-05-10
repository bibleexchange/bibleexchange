<?php namespace BibleExchange\Http\Controllers\Api;

use BibleExchange\Entities\Comment;
use BibleExchange\Entities\Study;
use Illuminate\Database\Eloquent\Collection;
use BibleExchange\Entities\Transformers\StudyTransformer;
use BibleExchange\Entities\Transformers\CommentTransformer;
use BibleExchange\Http\Requests\CreateStudyApiRequest;
use BibleExchange\Commands\CreateStudyCommand;
use Input, Auth, Str;

class ApiStudiesController extends ApiController {
	/**
	 * 
	 *
	 * @var /Entities/Transformers/StudyTransformer
	 */
	protected $StudyTransformer;
	
	function __construct(StudyTransformer $StudyTransformer, CommentTransformer $CommentTransformer){
		
		$this->StudyTransformer = $StudyTransformer;
		$this->commentTransformer = $CommentTransformer;
		
		$this->middleware('auth.basic',['only'=>['store']]);
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
		$study = new Study;
		$studies = $study->public()->paginate($limit);
		
		return $this->respondWithPagination($studies,
				[
				'data'=>$this->StudyTransformer->transformCollection($studies->all()),
				]
		);
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateStudyApiRequest $request)
	{
		if ( ! Input::get('title') or ! Input::get('content'))
		{			
			//422 unprocessable entity
			return $this->setStatusCode(422)
				->respondWithError('Parameters failed validation for a lesson');
		}
		
		$study = $this->dispatch(new CreateStudyCommand(
					Input::get('title'), 
					Auth::user()->id, 
					Str::slug(Input::get('title')),
					Input::get('content')
				));
		
		return $this->setStatusCode(201)->respond([
				'status'=>'success',
				'message'=>'Study successfully created.'
		]);
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($study)
	{		
		if( $study  && $study->isPublic()){
			
			return $this->respond([
					'data'=>$this->StudyTransformer->transform($study)
			]);
			
		}
		
		return $this->respondNotFound('Study does not exist.');
		
	}
	
	public function comments($study)
	{
		
		if( $study && $study->isPublic()){

			return $this->respond([
					'data'=>$this->commentTransformer->transformCollection($study->comments()->orderBy('created_at','DESC')->get()->all())
			]);
				
		}
		
		return $this->respondNotFound('Study does not exist.');
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
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
		//
	}
	
}
