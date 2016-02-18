<?php namespace BibleExchange\Presenters;

use Illuminate\Support\Str;

class BookmarkPresenter extends Presenter {
	
	public function title(){
		return ucwords($this->entity->title);
	}
	
	public function created_at(){
		return $this->entity->created_at->format('M. d, Y h:m a');
	}
	
	public function updated_at(){
		return $this->entity->updated_at->format('M. d, Y h:m a');
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
		
	if ($this->entity->description === NULL)
		{
			if ($this->entity->content_format === 'md'){

				$description =  Str::limit( preg_replace('/#/', ' ', $this->entity->content), 200);
			}else{
				$description =  Str::limit( preg_replace('/(<.*?>)|(&.*?;)/', '', $this->entity->content), 200);
			}
			
			$lesson = \BibleExchange\Entities\Lesson::find($this->entity->id);
			$lesson->description = $description;
			$lesson->save();
			
		}
		
		return $this->entity->description;
		
	}

	public function keywords()
	{
		return $this->entity->keywords;
	}
	
}