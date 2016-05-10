<?php namespace BibleExchange\Http\Controllers;

use Auth,Cache,Input,Flash, Redirect, Evernote;

class EvernoteController extends Controller {
	
	function __construct()
	{	
		$this->middleware('auth');
		
	}
	
	public function index()
    {
		
		$sync = new BibleExchange\BeSync\Synchronizer(Auth::user, 120);
		
		$notebooks = $this->evernoteClient->listNotebooks();
		$store = $this->evernoteClient->getUserNotestore();
		//$userStore = $this->evernoteClient->getAdvancedClient()->getUserStore();
		
		dd($store->getSyncState());
		
		$afterUSN = 0;
        $maxEntries = 25;
		$filter_values = [
			'includeNotes'=>true,
			'includeNoteResources' => false,
			'includeNoteAttributes' => false,
			'includeNotebooks' => false,
			'includeTags' => true,
			'includeSearches' => false,
			'includeResources' => false,
			'includeLinkedNotebooks' => false,
			'includeExpunged' => false,
			'includeNoteApplicationDataFullMap' => false,
			'includeResourceApplicationDataFullMap' => false,
			'includeNoteResourceApplicationDataFullMap' => false,
			'requireNoteContentClass' => false,
		];

		$filter = new \EDAM\NoteStore\SyncChunkFilter($filter_values);
		
		dd($store->getFilteredSyncChunk($afterUSN,$maxEntries,$filter));
		//$this->translateApiResponse();
		
		return view('users.content.index',compact('notebooks'));
	}
	
	public function show($notebook_guid)
    {    
		$notebook = $this->evernoteClient->getNotebook($notebook_guid);
		$store = $this->evernoteClient->getUserNotestore();
		
		$filter_values = ['notebookGuid'=>$notebook_guid];
		$spec_values = ['includeTitle'=>true];
		$offset = 0; 
		$maxNotes = 5;
		$spec = new \EDAM\NoteStore\NotesMetadataResultSpec($spec_values);
		$filter = new \EDAM\NoteStore\NoteFilter($filter_values);
		
		$notesInNotebook = $store->findNotesMetadata($filter,$offset,$maxNotes,$spec);
		
		return view('users.content.show',compact('notebook','notesInNotebook'));
	}
	
	public function showNote($note_guid)
    {  
		$key = $note_guid;

		if (Cache::has($key))
		{
			//Cache::forget($key);
			$note = Cache::get($key);
		}else{
			$note = $this->evernoteClient->getNote($note_guid);
			Cache::put($key, $note, $this->cacheMinutes);
		}
		dd($this->evernoteClient->getNote($note_guid));
		$evernote_user_info = $this->evernoteClient->getAdvancedClient()->getUserStore()->getUser();
		
		return view('users.content.show-note',compact('note','evernote_user_info'));
	}
	
	public function search($search_term, $notebook = null)
    {    

		$search = new \Evernote\Model\Search($search_term);
		$scope = null;
		$order = \Evernote\Client::SORT_ORDER_REVERSE | \Evernote\Client::SORT_ORDER_RECENTLY_CREATED;
		$maxResult = 5;

		$notes = $this->evernoteClient->findNotesWithSearch($search, $notebook, $scope, $order, $maxResult);
	
		return view('users.content.search',compact('notes','search_term'));
	}
	
	public function testing()
    {    
		$notebook_guid = '902cc7cd-ef5d-414e-a3a7-d7441b746ff6';		
		$notebooks = $client->listNotebooks();
		$notebook = $client->getNotebook($notebook_guid);
		
		$store = $client->getUserNotestore();
		
		$filter_values = ['notebookGuid'=>$notebook_guid];
		$spec_values = [];
		$offset = 0; 
		$maxNotes = 5;
		$spec = new \EDAM\NoteStore\NotesMetadataResultSpec($spec_values);
		$filter = new \EDAM\NoteStore\NoteFilter($filter_values);
		
		$notesInNotebook = $store->findNotesMetadata($filter,$offset,$maxNotes,$spec);
		
		$note_guid = '815a53a0-7323-4de5-97f2-a166cc7806ed';
		$searchString = 'Jesus';
		$noteSearch = new \Evernote\Model\Search($searchString);
		
		$notesBySearch = $client->findNotesWithSearch($noteSearch, $notebook);
		
		$note = $client->getNote($note_guid);
		$tagNames = ['twenty','fourteen','gospel'];
		$note->setTagNames($tagNames);

		$store->updateNote($note);
    }
	
	public function postAuth()
    {    
		
		dd('post');
		
    }
	
	/* The Following Functions Should be in a Command and Handler */
	
	public function create_note()
	{
		$client = Evernote::get_simple_client();		
		
		$note = Evernote::create_note('This is my Second Title',"<blockquote>This is my Content</blockquote>",['test','published','be']);
		$notebook = null;
		
		$client->uploadNote($note, $notebook);
		
    	return view('evernote.auth');
	}
	
}