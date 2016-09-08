<?php

namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class StepAttachments extends Model
{

  protected $fillable = ['order_by','object_type_id','object_id','description','meta'];
  protected $appends = ['obj'];
  protected $table = 'attachments';


    public function step(){
	return $this->belongsTo('BibleExperience\Step');
    }

    public function type(){
	return $this->belongsTo('BibleExperience\ObjectTypes','object_type_id');
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
