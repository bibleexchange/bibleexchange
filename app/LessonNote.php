<?php namespace BibleExperience;

class LessonNote extends BaseModel {

  public $timestamps = true;
  protected $table = 'lesson_note';
  protected $fillable = ['lesson_id', 'note_id', 'order_by', 'created_at', 'updated_at'];
  protected $appends = ['next','previous'];


  public function note() {
    return $this->belongsTo('\BibleExperience\Note');
  }
  
  public function lesson() {
    return $this->belongsTo('\BibleExperience\Lesson');
  }
  

public function getNextAttribute()
{
  if($this->order_by < $this->lesson->notesCount){
	return $this->lesson->notes()->where('order_by',$this->order_by+1)->first();
  }else{
	return $this->lesson->notes()->where('order_by',1)->first();
	}
}

public function getPreviousAttribute()
{
  if($this->order_by !== 1){
	return $this->lesson->notes()->where('order_by',$this->order_by-1)->first();
  }else{
	return $this->lesson->notes()->where('order_by',1)->first();
  }
}

  public static function updateFromArray(Array $array_of_props)
    {
	
        if(!isset($array_of_props['id'])){
            return response()->json(['error' => 'id_was_not_given', 'code'=>500, 'lessonNote'=> new LessonNote]);
        }else{

	  $root = LessonNote::find($array_of_props['id']);
	
	  unset($array_of_props['id']);

	  foreach($array_of_props AS $key => $value){
	    if (isset($root->$key)){
	    	$root->$key = $value;
	    }
	  }

	  try {
		$root->save();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'lessonNote'=> new LessonNote]);
	  };

	  return ['error' => null, 'code'=>200, 'lessonNote'=> $root];

	}

       
    }

  public static function createFromArray(Array $array_of_props)
    {

	  $lessonnote = new LessonNote;
	  unset($array_of_props['clientMutationId']);	
	  unset($array_of_props['id']);

	  foreach($array_of_props AS $key => $value){
	    	$lessonnote->$key = $value;
	  }

	  try {
		$lessonnote->save();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'lessonnote'=> $lessonnote]);
	  };

	  return ['error' => null, 'code'=>200, 'lessonnote'=> $lessonnote];
       
    }

  public static function destroyFromRelay($lessonNoteId)
    {
	$lessonnote = LessonNote::find($lessonNoteId);

	  try {
		$lessonnote->delete();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'lessonnote'=> $lessonnote]);
	  };

	  return ['error' => null, 'code'=>200, 'lessonnote'=> $lessonnote];
       
    }

}
