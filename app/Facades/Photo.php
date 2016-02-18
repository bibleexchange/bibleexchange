<?php namespace BibleExchange\Facades;

use Illuminate\Support\Facades\Facade;

class Photo extends Facade {

	protected static function getFacadeAccessor()
	{
		return new \BibleExchange\Presenters\ImagePresenter;
	}

}