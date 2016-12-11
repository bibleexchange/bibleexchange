<?php namespace BibleExperience\Core;

//Instructions:
//be sure to add "uui" to $appends array


trait UUIDTrait {

  public function getUUIDAttribute()
    {
	return base64_encode(get_class ($this) . "_" . $this->id);
    }
		
}
