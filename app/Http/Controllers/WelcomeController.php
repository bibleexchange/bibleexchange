<?php namespace BibleExchange\Http\Controllers;

use \stdClass;

class WelcomeController extends Controller {

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		
		$meta = $this->meta();

		return view('pages.landing',compact('meta'));
	}
	
	public function meta(){
	
		$meta = new stdClass();

		$meta->keywords = 'faith, hope, bible, study, learn';
		$meta->author = 'Deliverance Center';
		$meta->title = 'Bible Exchange';
		$meta->description = 'Bible exchange is your companion in discovery. Equip yourself to better know and share your faith in Jesus Christ by engaging in Biblical conversation.';//No more than 155 characters
		$meta->shareImage = 'http://bible.exchange/images/be_logo.png';//Twitter summary card with large image must be at least 280x150px
		$meta->siteName = 'Bible exchange';
		$meta->publisherTwitterHandle = '@bible_exchange';
		$meta->authorTwitterHandle = '@mjamesderocher';
		$meta->ogurl = 'http://bible.exchange/index'; //current url
		$meta->articlePublished = '2015-02-25T19:08:47+01:00';//2013-09-16T19:08:47+01:00
		$meta->articleModified = '2015-02-25T19:08:47+01:00';//2013-09-16T19:08:47+01:00
		$meta->facebookAppId = '1529479753993292';
		$meta->articleSection = 'Index of Bible exchange';
		$meta->articleTag = $meta->keywords;
		
		return $meta;
	}
	
}