<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Bookmark extends Model {
	
	use PresentableTrait;
	
	protected $fillable = ['url','user_id','created_at','updated_at'];
	
	protected $presenter = 'BibleExchange\Presenters\BookmarkPresenter';
	
	//returns this column as Carbon instances!
	public function getDates()
	{
		return ['created_at','updated_at'];
	}
	
	public function user()
    {
        return $this->belongsTo('User');
    }
	
}