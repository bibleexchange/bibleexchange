<?php namespace BibleExchange\Presenters;

class NotePresenter extends Presenter {

    /**
     * Display how long it has been since the publish date.
     *
     * @return mixed
     */
    public function timeSincePublished()
    {
        return $this->created_at->diffForHumans();
    }
	
    public function tagsAsString()
    {
    	return $this->tags;
    }
    
}