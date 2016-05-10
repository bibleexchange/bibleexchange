<?php namespace BibleExchange\Presenters;

class PagePresenter extends Presenter {

	public function title(){
		return ucwords(str_replace(['_','-','/'],['-',' ',': <BR>'], $this->entity->title));
	}

}