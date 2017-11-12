<?php namespace BibleExperience;

use Illuminate\Support\Facades\URL;
use BibleExperience\Core\PresentableTrait;
use BibleExperience\Core\ShortableTrait;
use BibleExperience\Presenters\Contracts\PresentableInterface;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Build\Course AS BuildCourse;
use Str, Cache, stdclass;

class Textbook extends BaseModel implements PresentableInterface {

	public $fillable = array('course_id','html','lang','created_at','updated_at');

	protected $appends = [];

	//protected $presenter = 'BibleExperience\Presenters\Course';

	use PresentableTrait, ShortableTrait, GlobalIdTrait;

 public function course()
  {
  	return $this->belongsTo('BibleExperience\course','course_id');
  }


			

}
