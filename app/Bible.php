<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Bible extends BaseModel {

	protected $table = 'bibles';
	
	public $timestamps = false;
	
	protected $fillable = ['abbreviation','language','version','info_text','info_url','publisher','copyright','copyright_info'];
	
	public function books()
    {
        return $this->belongsToMany('\BibleExperience\BibleBook');
    }
	
}

