<?php namespace BibleExchange\Presenters;

use Str;
use BibleExchange\Helpers\Helpers as Helper;

class StudyPresenter extends Presenter {

	public function title(){
		return ucwords(str_replace(['_','-','/'],['-',' ',': '], $this->entity->title));
	}
	
	public function urlTitle(){
		return Helper::userTitletoUrl($this->entity->title);
	}
	
	public function created_at(){
		return $this->entity->created_at->format('M. d, Y h:m a');
	}
	
	public function updated_at(){
		return $this->entity->updated_at->format('M. d, Y h:m a');
	}
	
	public function lastChangeWasMade(){
		
		if ( $this->entity->lastChangeWasMade > \Carbon::now()->subYears(20)){
		
		return \Carbon::now()->parse($this->entity->lastChangeWasMade)->diffForHumans();
		
		} else {
			return null;
		}
		
	}
	
	public function ItuneslastChangeWasMade(){

			return $this->entity->published_at->toRfc2822String();	
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
	
	public function tagsAsString()
	{
		return implode(', ', $this->tags->lists('name'));
	}

}