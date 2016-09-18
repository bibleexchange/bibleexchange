<?php

namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class StepAttachment extends Model
{

  protected $fillable = ['step_id','order_by','object_type_id','object_id','meta'];
  protected $appends = ['description'];
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

    public function obj(){
	return $this->belongsTo($this->type->classname,'object_id');
    }

    public function getMeta($index){
	$m = json_decode($this->meta);
	if(property_exists($m, $index)){
	  return $m->$index;	
	}else{
	  return null;	
        }
   }

    public function getDescriptionAttribute(){

	return $this->getMeta('description');	
   }

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
