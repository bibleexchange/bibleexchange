<?php

namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class StepAttachment extends Model
{

  protected $fillable = ['step_id','order_by','object_type_id','object_id','meta'];
  protected $appends = ['obj'];
  protected $table = 'step_attachments';

	public static function make( $step_id, $order_by, $object_type_id, $object_id, $meta)
	{
		$attachment = new static(compact('step_id', 'order_by', 'object_type_id', 'object_id', 'meta'));

		return $attachment;
	}

    public function step(){
	return $this->belongsTo('BibleExperience\Step');
    }

    public function type(){
	return $this->belongsTo('BibleExperience\ObjectType','object_type_id');
    }

    public function getObjAttribute(){
	return $this->type->classname::find($this->object_id);
    }
   
/*
SUBJECT: "USER"
OBJECT: "Activity","Article"
PROGRESS: "EXPERIENCED","COMPLETED"


ACTIONS:
===================
Read
Hear
Watch
Research
Respond


ATTACHMENTS:
===================
Media Inline (Audio, Video, WebPage)
Link
Text
Test
BibleVerse
BibleVerseList
BibleChapter

*/

}
