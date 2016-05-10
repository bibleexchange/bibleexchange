<?php namespace BibleExchange\Http\Controllers;

class EditorController extends Controller {

function __construct()
	{
		$this->user = User::find(Auth::user()->id);
		$this->Str = new Strings();
	}
		
	public function index() {		
		 $id = '1J1_nRdjVOon0lF4HKhRE-BiS0Jz6uTvEdn_M5nA2uWI';
		$Lesson = new Lesson();
   $notes = $Lesson->getGDoc($id, 60);
   
   $edit_doc = '<a target="_blank" href="https://docs.google.com/a/deliverance.me/document/d/'.$id.'/edit" class="btn btn-primary">EDIT in GDrive <span class="glypicon glyphicon-pencil"></span></a>';
		
		 return View::make('editorDocs',[
			'pageTitle'=>NULL,
			'User' => Auth::user(),	
			'notes'=>$edit_doc.$notes
			]);		
	
	}
	
	public function show($id){
	
		$Chapter = Chapter::find($id);
		$courseTitle = $this->Str->prettyName($Chapter->courses()->title);
		
		$path = app_path().'/assets/docs/'.$courseTitle;
		
		$files = glob($path.'/'.$Chapter->id.'_*');
		$file = $files[0];

		$notes = file_get_contents($file); 
		
		return View::make('editorMarkdown',[
			'pageTitle'=>'Edit',
			'User' => Auth::user(),	
			'notes'=>$notes,
			'chapterId'=>$Chapter->id
			]);		
		
	}
	
	public function update(){
	
		$directory = 'suggested_edits/'.$_POST['userId'];
		
		if (!file_exists($directory)) {
		var_dump('directory not exist');
			mkdir($directory, 0777, true);
		}
	
		file_put_contents($directory.'/'.$_POST['chapterId'].'.txt',$_POST['notes']);
	}
	
	public function gdrive($doc) {
	
	switch ($doc) {
    case 'standards':
        $id = '1J1_nRdjVOon0lF4HKhRE-BiS0Jz6uTvEdn_M5nA2uWI';
        break;
    default:
          $id = '1J1_nRdjVOon0lF4HKhRE-BiS0Jz6uTvEdn_M5nA2uWI';
}
	
	$Lesson = new Lesson();
   $notes = $Lesson->getGDoc($id, 60);
   
   $edit_doc = '<a target="_blank" href="https://docs.google.com/a/deliverance.me/document/d/'.$id.'/edit" class="btn btn-primary">EDIT in GDrive <span class="glypicon glyphicon-pencil"></span></a>';
   
   
   return View::make('editorDocs',[
			'pageTitle'=>NULL,
			'User' => Auth::user(),	
			'notes'=>$edit_doc.$notes
			]);		
	}
	
}