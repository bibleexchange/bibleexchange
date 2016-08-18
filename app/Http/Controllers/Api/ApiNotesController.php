<?php namespace BibleExperience\Http\Controllers\Api;

use BibleExperience\Note;
use Illuminate\Database\Eloquent\Collection;
use BibleExperience\Transformers\NoteTransformer;
use BibleExperience\NoteRepository;
use BibleExperience\UserRepository;
use Input, Auth, Str;

class ApiNotesController extends ApiController {
	/**
	 * 
	 *
	 * @var /Transformers/NoteTransformer
	 * @var /Transformers/NoteRepository
	 */
	protected $noteTransformer;
	protected $noteRepository;
	protected $userRepository;
	
	function __construct(noteTransformer $noteTransformer,NoteRepository $noteRepository, UserRepository $userRepository){
		
		$this->noteTransformer = $noteTransformer;
		$this->noteRepository = $noteRepository;
		$this->userRepository = $userRepository;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$limit = Input::get('limit') ?: 1;
		
		if ($limit > 15){$limit = 15;}
		
		$lessons = Lesson::paginate($limit);
		
		return $this->respondWithPagination($lessons,
				[
				'data'=>$this->noteTransformer->transformCollection($lessons->all()),
				]
		);
	}
	
	public function bibleChapter($book, $chapterOrderBy)
	{
		if(isset($_GET['count'])){
			$limit = $_GET['count'];
		}else{
			$limit = 5;
		}
	
		if ($limit > 15){$limit = 15;}
	
		$chapter = $book->chaptersByOrderBy($chapterOrderBy);
		$notes = $this->noteRepository->getFeedForUserWhereVerses(Auth::user(),$chapter->verses->lists('id')->toArray(),$limit);
		
		return $this->respondWithPagination($notes,
				[
						'data'=>$this->noteTransformer->transformCollection($notes->all()),
				]
		);
	}
	
	public function bibleVerse($verse)
	{
		if(isset($_GET['count'])){
			$limit = $_GET['count'];
		}else{
			$limit = 5;
		}
	
		if ($limit > 15){$limit = 15;}
	
		$notes = $this->noteRepository->getFeedForUserWhereVerse(Auth::user(),$verse,$limit);
	
		return $this->respondWithPagination($notes,
				[
						'data'=>$this->noteTransformer->transformCollection($notes->all()),
				]
		);
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
	
		$notes = $this->noteRepository->getAllForUser($user,$limit);
	
		return $this->respondWithPagination($notes,
				[
					'data'=>$this->noteTransformer->transformCollection($notes->all()),
				]
		);
	}
	
	public function showArrayOfNotes($array)
	{
		$array = explode('_',$array);
		$notes = Note::whereIn('id',$array)->get();

		return view('notes.show', compact('notes'));
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
