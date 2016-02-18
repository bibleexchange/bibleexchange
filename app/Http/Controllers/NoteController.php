<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests\PublishNoteRequest;
use BibleExchange\Commands\CreateBibleNoteCommand;
use BibleExchange\Entities\NoteRepository;
use BibleExchange\Entities\BibleVerse;
use BibleExchange\Entities\Image;
use BibleExchange\Entities\Note;
use Auth, Input, Flash, Redirect, Str;

class NoteController extends Controller {

 /**
     * @var NoteRepository
     */
    protected $noteRepository;

    /**
     * @param PublishNoteForm $publishNoteForm
     * @param NoteRepository $noteRepository
     */
    function __construct(NoteRepository $noteRepository)
    {
    	$this->middleware('auth', ['except' => 'show']);
    	$this->noteRepository = $noteRepository;
    }
	
	public function show($note)
	{	
		$notes[0] = $note;
		
		return view('notes.show', compact('notes'));
	}
	
	/**
	 * Save a new note
	 *
	 * @return Response
	 */
	public function store(PublishNoteRequest $request)
	{
		
		if($_SERVER['CONTENT_LENGTH'] >= 2022645){
			Flash::error('file was too large');
			return Redirect::back();
		}
		
		$input = Input::all();

		if(BibleVerse::find($input['bible_verse_id']) !== null){
			$verse = $input['bible_verse_id'];
		}else{
			$verseExists = BibleVerse::referenceTranslator($input['bible_verse_id']);
			$verse = $verseExists[0];
		}
		
		$verseObject = BibleVerse::find($verse);
		
		if (isset($input['note_image'])){
		
			$imageMade = \Photo::make($input['note_image']->getRealPath());
			$name = \Auth::user()->id . '-' . \Str::random(30);
			$fileName = '/images/members/'. $name . '.' . str_replace('image/','',$imageMade->mime());
			 
			$destination = base_path().'/resources'.$fileName;
			$imageMade->save($destination);
			
			$image = new Image;
			$image->name = $name;
			$image->src = $fileName;
			$image->alt_text = $verseObject->reference. ' image';
			$image->user_id = Auth::user()->id;
			$image->bible_verse_id = $verse;
			$image->save();
			
			$image_id = $image->id;
			
		}else {
			$image_id = null;
		}
		
		$input = [
				'body'=>$input['body'],
				'userId'=>Auth::id(),
				'bible_verse_id'=>$verse,
				'image_id'=>$image_id
		];
			
		$this->dispatch(new CreateBibleNoteCommand($input));
		
		Flash::success('Your note has been created!');
		
        return Redirect::back();
	}
	
	public function delete($note)
	{
		$user = Auth::user();
		
		if ($note->user_id === $user->id){
			
			Note::destroy($note->id);
			Flash::success('Your note has been deleted!');

		}else{
		
			Flash::warning('You don\'t have permission to delete this!');
		
		}
		
		return Redirect::back();
		
	}
	
	
	
}
