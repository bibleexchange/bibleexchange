<?php namespace BibleExperience;

class ResourceSection extends BaseModel {

	protected $table = 'resource_section';

	public $fillable = array('url','cache');
	protected $appends = array('text');
	public $timestamps = false;	

 	public function getTextAttribute()
    {
        return $this->cache;
    }

    public function crossReferences()
    {
        return $this->hasMany('\BibleExperience\ResourceCrossReference','section_id');
    }

}
