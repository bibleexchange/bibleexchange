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
	
    public function chapters()
    {
        return $this->hasMany('\BibleExperience\BibleChapter','bible_version_id');
    }
	
    public function verses()
    {
        return $this->hasMany('\BibleExperience\BibleVerse','bible_version_id');
    }

    public static function getVersion($version = null)
    {        
	$bible =  Bible::find($version);

	if($bible !== null){return $bible; }else{return Bible::find(1);}
    }

public static function scopeSearch($query,$search)
{
	return $query->where('abbreviation',$search)
		->orWhere('version','LIKE','%'.$search.'%')
		->get();
}

}

