<?php namespace BibleExperience;

use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\AmenableTrait;
use BibleExperience\Core\CommentableTrait;
use GrahamCampbell\Markdown\Facades\Markdown;
use BibleExperience\BibleVerse;
use BibleExperience\Note;
use BibleExperience\NoteCache;
use Symfony\Component\Debug\Exception;

use stdClass;

class Quiz extends BaseModel {

    protected $fillable = ['title','raw_questions','solution','lesson_id','created_at','updated_at'];
    protected $appends = ['questions'];

  public function lesson()
  {
    	return $this->belongsTo('BibleExperience\Lesson','lesson_id');
  }

 public function getQuestionsAttribute()
  {
      return $this->raw_questions;
  }

}