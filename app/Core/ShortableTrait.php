<?php namespace BibleExperience\Core;

trait ShortableTrait {

	public function shorts()
	{
		return $this->morphMany('BibleExperience\UrlShort','shortable');
	}
		
}