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

}
