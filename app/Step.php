<?php namespace BibleExperience;

class Step extends BaseModel {

  public $timestamps = true;
  protected $table = 'steps';
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
    return $this->lesson->steps()->where('order_by',$this->order_by+1)->first();
  }

  public function getPreviousAttribute()
  {
    return $this->lesson->steps()->where('order_by',$this->order_by-1)->first();
  }

  public static function updateFromArray(Array $array_of_props)
    {

        if(!isset($array_of_props['id'])){
            return response()->json(['error' => 'id_was_not_given', 'code'=>500, 'step'=> null]);
        }else{

	  $step = Step::find($array_of_props['id']);

	  unset($array_of_props['id']);

	  foreach($array_of_props AS $key => $value){
	    if (isset($step->$key)){
	    	$step->$key = $value;
	    }
	  }

	  try {
		$step->save();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'step'=> null]);
	  };

	  return ['error' => null, 'code'=>200, 'step'=> $step];

	}


    }

  public static function createFromArray(Array $array_of_props)
    {

	  $step = new Step;
	  unset($array_of_props['clientMutationId']);
	  unset($array_of_props['id']);

	  foreach($array_of_props AS $key => $value){
	    	$step->$key = $value;
	  }

	  try {
		$step->save();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'step'=> $step]);
	  };

	  return ['error' => null, 'code'=>200, 'step'=> $step];

    }

  public static function destroyFromRelay($stepId)
    {
	$step = Step::find($stepId);

	  try {
		$step->delete();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'step'=> $step]);
	  };

	  return ['error' => null, 'code'=>200, 'destroyedStepId'=> $stepId];

    }

    public static function getContent($step){

      $content = new \stdClass;

      switch($step->type){
        case "note":
          $content->value = Note::find($step->id);
          $content->type = 'note';
          $content->html = $content->value->output->body;
          break;
        case "bible":
          $verses = BibleVerse::findVersesByReference($step->id)->toArray();
          $content->value =  $verses;
          $content->type = 'bible';
          $t = '';

          foreach($verses AS $verse){
            $t = $t . ' ' . $verse['quote'];
          }

          $content->html = $t;
          break;

        default:
          $content = null;
      }

      return $content;


    }

}
