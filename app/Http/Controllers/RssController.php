<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Entities\Course;
use BibleExchange\Entities\Study;
use Carbon, stdClass, Response;

class RssController extends Controller {
	
	/**
	 * Display a listing of the resource.
	 * GET /rss
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$content = $this->studies();
		
		return Response::make($content,'200')->header('Content-Type','text/xml');
	}
	
	public function getFeed($course)
	{

		if (!is_null($course)){
			$content = $this->course($course);
		}else{
			$content = $this->studies();
		}
		
		return Response::make($content,'200')->header('Content-Type','text/xml');
		
	}
	
	private function course($course){

		$feed = $this->mapFeed($course);
		$entries = $this->mapEntries($course->studies(), $course);
		$content = view('pages.rss',compact('entries', 'feed'));
		
		return view('pages.rss',compact('entries', 'feed'));
	}
	
	private function studies(){
	
		$studies = Study::orderBy('created_at','DESC')->limit(25)->get();
		$feed = $this->mapFeedSite();
		$entries = $this->mapEntries($studies);
			
		return view('pages.rss',compact('entries', 'feed'));
	}
	
	private function mapFeedSite(){
	
		$feed = new stdClass();
		$feed->id	=	'http://bible.exchange';
		$feed->title	=	'Bible exchange most recent studies.'; //iTunes Store: Top Podcasts in Religion &amp; Spirituality
		$feed->updated	=	\Carbon\Carbon::now()->toRfc3339String() ; 
		$feed->link_alternate	=	'http://bible.exchange';
		$feed->link_self	= 'http://bible.exchange/rss';
		$feed->icon	=	'http://bible.exchange/assets/favicon.ico';
		$feed->authorName	=	'Bible exchange';
		$feed->authorUri	=	'http://bible.exchange/';
		$feed->rights	=	'Copyright 2014 Deliverance Center, Inc.';
		
		return $feed;
	}
	
	private function mapFeed($course){
		
		$feed = new stdClass();
		$feed->id	=	'http://bible.exchange/course/'.$course->id;//https://itunes.apple.com/us/rss/toppodcasts/limit=10/genre=1314/xml
		$feed->title	=	$course->title; //
		$feed->channel_url	=	$course->url();
		$feed->url	= $course->url().'/rss';		
		$feed->created_date = $course->present()->itunes_created_at;
		$feed->updated_date = Carbon::now()->toRfc2822String();
		$feed->icon	=	'http://bible.exchange/images/be_logo.png';
		$feed->authorName	=	'Bible exchange';
		$feed->authorUri	=	'http://bible.exchange/';
		$feed->rights	=	'Copyright 2014 Deliverance Center, Inc.';
		$feed->description = $course->description;
		$feed->items_count = $course->studies()->count();
		$feed->image = $course->defaultImage;
	
		return $feed;
	}
	
	private function mapEntries($studies, $course){
	/*
	 * UPDATE `studies` 
SET `created_at`= '2014-01-01 01:01:01'
WHERE `created_at` = '0000-00-00 00:00:00'
	 * 
	 * */
		$array = array();
		
		foreach($studies as $study){
		
			$entry = new stdClass(); 
			$entry->guid = $study->url();
			$entry->title = $study->title;
			$entry->subtitle = $study->title;
			$entry->summary = $study->description; 			//Classic sermons by Timothy Keller, Pastor of Redeemer Presbyterian Church ...and NY Times best-selling author
			$entry->imName = $course->title; 			//Timothy Keller Podcast
			$entry->link = $study->url();
			$entry->linkAlternate = $course->url(); 	//https://itunes.apple.com/us/podcast/timothy-keller-podcast/id352660924?mt=2&amp;uo=2
			$entry->imArtist = $study->creator->fullname;
			$entry->image  = $study->defaultImage->src;
			$entry->image55x55  = $study->defaultImage->src . '?w=55&h=55'; 		//http://a1000.phobos.apple.com/us/r30/Podcasts/d5/5a/29/ps.syqsdznq.55x55-70.jpg
			$entry->image60x60 = $study->defaultImage->src . '?w=60&h=60'; 		//http://a1722.phobos.apple.com/us/r30/Podcasts/d5/5a/29/ps.syqsdznq.60x60-50.jpg
			$entry->image170x170 = $study->defaultImage->src . '?w=170&h=170'; 		//http://a57.phobos.apple.com/us/r30/Podcasts/d5/5a/29/ps.syqsdznq.170x170-75.jpg
			$entry->rights = $course->rights; 			//&#169; Copyright 2010, Redeemer Presbyterian Church of New York
			$entry->updatedLast = $study->present()->ItuneslastChangeWasMade; 		// 2014-10-22T13:48:00-07:00			
			$entry->updatedLastLabel =  $study->published_at->format('m d, Y'); //October 22, 2014
			
			$entry->author = $study->creator->fullname;
			
			$podcast = $study->recordings()->soundcloud()->first();
			
			if($podcast !== null){
				
				$podcast = $podcast->formats()->soundcloud()->first();
				
				$entry->recording_duration = '00:00:00';//'HH:MM:SS';
				
				switch($podcast->format){
					
					case 'soundcloud-mp3':
						$entry->recording_type = 'audio/mpeg';
						$ext = '.mp3';
						break;
					case 'soundcloud-m4a':
						$entry->recording_type = 'audio/x-m4a';
						$ext = '.m4a';
						break;
					default:
						$entry->recording_type = 'audio/mpeg';
						$ext = '.mp3';
					
				}
				
				$entry->recording_download_url = 'http://feeds.soundcloud.com/stream/' . $podcast->file . $ext;
				
				
				$entry->recording_length = '0';//size in bytes = 9691730
			}else{
				$entry->recording_duration = '00:00:00';
				$entry->recording_download_url = '';
				$entry->recording_type = '';
				$entry->recording_length = '0';
			}
			
			
			$array[] = $entry;
		}
		return $array;
	}
	
}