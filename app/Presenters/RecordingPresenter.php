<?php namespace BibleExchange\Presenters;

use Str;
use BibleExchange\Helpers\Helpers as Helper;

class RecordingPresenter extends Presenter {

	public function title(){
		return ucwords(str_replace(['_','-','/'],['-',' ',': '], $this->entity->title));
	}
	
	public function urlTitle(){
		return Helper::userTitletoUrl($this->entity->title);
	}
	
	public function created_at(){
		return $this->entity->created_at->format('M. d, Y h:m a');
	}
	
	public function dated(){
		
		if($this->entity->dated == \Carbon::parse('1900-01-01 19:00:00')){
			return 'Actual date is missing. Probably from sometime before the 1990&apos;s.';
		}
		
		return $this->entity->dated->format('M. d, Y h:m a');
	}
	
	public function updated_at(){
		return $this->entity->updated_at->format('M. d, Y h:m a');
	}
	
	public function lastChangeWasMade(){//2015-03-18 00:04:21
			return \Carbon::now()->parse($this->entity->lastChangeWasMade)->diffForHumans();
		}
	
	public function content()
	{
		if(isset($this->entity->content)) {return nl2br($this->content);}
	
		return null;
	}
	/**
	 * Get the post's meta_description.
	 *
	 * @return string
	 */
	public function description()
	{

		if ($this->entity->content_format === 'md'){
			$description =  Str::limit( preg_replace('/#/', ' ', $this->entity->description), 18);
		}else{
			$description =  Str::limit( preg_replace('/(<.*?>)|(&.*?;)/', '', $this->entity->description), 180);
		}
	
		return $description;
	
	}
	
	public function keywords()
	{
		return $this->entity->keywords;
	}

}