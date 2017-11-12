<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Resource extends BaseModel {

    protected $table = 'resources';
	
    public $timestamps = false;
	
    protected $fillable = ['title','author'];
    protected $appends = array('text');

	
    public function getTextAttribute()
    {
        return "<h1>All the Text Here</h1>";
    }
	
    public function sections()
    {
        return $this->hasMany('\BibleExperience\ResourceSection','resource_id');
    }

    public function crossReferences()
    {
        return $this->hasManyThrough('\BibleExperience\ResourceCrossReference','\BibleExperience\ResourceSection');
    }

}

