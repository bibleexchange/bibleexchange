<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Bookmark extends Model {
	
	use PresentableTrait;
	
	protected $fillable = ['url','user_id','created_at','updated_at'];
	
	protected $presenter = 'BibleExperience\Presenters\BookmarkPresenter';
	
	//returns this column as Carbon instances!
	public function getDates()
	{
		return ['created_at','updated_at'];
	}
	
	public function user()
    {
        return $this->belongsTo('\BibleExperience\User');
    }
	
}