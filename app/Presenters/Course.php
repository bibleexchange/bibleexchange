<?php namespace BibleExchange\Presenters;

class Course extends Presenter {
	
	public function title(){
		return strtoupper($this->entity->title);
	}
	
	public function created_at(){
		return $this->entity->created_at->format('M. d, Y h:m a');
	}

	public function updated_at(){
		return $this->entity->updated_at->format('M. d, Y h:m a');
	}

////$rss_feed_published_date = 'Sat, 21 Feb 2015 18:37:46 +0000';
	public function itunes_created_at(){
		return $this->entity->created_at->toRfc2822String();
	}
	
	public function itunesUpdatedAt(){
		return $this->entity->updated_at->toRfc2822String();
	}
	
	
}
