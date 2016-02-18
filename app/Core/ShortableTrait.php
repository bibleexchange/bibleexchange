<?php namespace BibleExchange\Core;

trait ShortableTrait {

	public function shorts()
	{
		return $this->morphMany('BibleExchange\Entities\UrlShort','shortable');
	}
		
}