<?php namespace BibleExperience\Entities;

class PageInfo {
	
	public $currentPage = 0;
	public $hasNextPage = false;
	public $hasPreviousPage = false;
	public $model = null;
	public $numberOfPages = 0;
	public $perPage = 0;
	public $size = 0;
	public $type = null;
	
	function __construct($type, $currentPage, $perPage){
		
		$this->currentPage = $currentPage;
		$this->perPage = $perPage;	
		$this->type = $type;
		$this->model = $this->getModel();
		$this->numberOfPages = $this->getNumberOfPages();
		
		$this->hasNextPage = $this->setNext();
		$this->hasPreviousPage = $this->setPrevious();
		
		
	}
	
	public function getModel(){
		
		switch ($this->type) {
			case 'notebooks':
				$model = Notebook::all();
				break;
			case 'notes':
				$model = Note::all();
				break;
			case 'biblechapters':
				$model = BibleChapter::all();
				break;

			default:
				$model = [];
		}
		
		$this->size = $model->count();
		return $model;
	}
	
	public function setPrevious(){
		if($this->currentPage > 1){
			return true;
		}else{
			return false;
		}
	}
	
	public function setNext(){
		if($this->currentPage < $this->numberOfPages){
			return true;
		}else{
			return false;
		}
	}
	
	public function getNumberOfPages(){
		
		if($this->perPage === 0){
			return 0;
		}
		
		$number = $this->model->count()/$this->perPage;
		
		return ceil($number);
	}

}