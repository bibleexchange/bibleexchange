<?php namespace BibleExchange\Http\Controllers\Api;

use BibleExchange\Entities\Amen;
use Illuminate\Database\Eloquent\Collection;
use BibleExchange\Entities\Transformers\AmenTransformer;
use BibleExchange\Entities\UserRepository;
use Input, Auth, Str;

class ApiAmensController extends ApiController {
	/**
	 * @var /Entities/Transformers/NoteTransformer
	 * @var /Entities/Transformers/NoteRepository
	 */
	protected $amenTransformer;
	protected $userRepository;
	
	function __construct(amenTransformer $amenTransformer, UserRepository $userRepository){
		
		$this->amenTransformer = $amenTransformer;
		$this->userRepository = $userRepository;
	}
	
	public function publicProfile($username)
	{
		$user = $this->userRepository->findByUsername($username);

		if(isset($_GET['count'])){
			$limit = $_GET['count'];
		}else{
			$limit = 5;
		}
	
		if ($limit > 15){$limit = 15;}
	
		$amens = $user->amens()->paginate($limit);
	
		return $this->respondWithPagination($amens,
				[
				'data'=>$this->amenTransformer->transformCollection($amens->all()),
				]
		);
	}
	
	public function showArrayOfAmens($array)
	{
		$array = explode('_',$array);
		$amens = Amen::whereIn('id',$array)->get();

		return view('amens.show', compact('amens'));
	}
	
	public function show($id)
	{
		$lesson = Lesson::find($id);
		
		if(! $lesson){
			
			return $this->respondNotFound('Lesson does not exist.');
			
		}
		
		return $this->respond([
				'data'=>$this->lessonTransformer->transform($lesson)
		]);
		
	}
	
}
