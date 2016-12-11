<?php namespace BibleExperience\Facades;

use Illuminate\Support\Facades\Facade;

class Photo extends Facade {

	protected static function getFacadeAccessor()
	{
		return new \BibleExperience\Presenters\ImagePresenter;
	}

}