<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

use BibleExperience\BibleVerse;

class CrossReference extends BaseModel {

	protected $table = 'cross_reference';
	protected $fillable = ['bible_verse_id','rank','start_verse','end_verse'];
	protected $appends = array('verses', 'reference','url');

	public function verse(){
		return $this->belongsTo('BibleExperience\BibleVerse','bible_verse_id');
	}

	public function getUrlAttribute(){
		return BibleVerse::find($this->start_verse)->url;		
	}

	public function getVersesAttribute(){
		return $this->getVersesRelationship()->get();
	}

	public function getVersesRelationship(){
		if($this->end_verse === 0 || $this->end_verse === '0' ){
			return BibleVerse::whereBetween('id',[$this->start_verse , $this->start_verse]);
		}else{
			return BibleVerse::whereBetween('id',[$this->start_verse , $this->end_verse]);
		};
	}

	public function verses(){
		return $this->getVersesRelationship();
	}

		public function getReferenceAttribute(){

			$start_verse = BibleVerse::find($this->start_verse);

		if($this->end_verse === 0){
			return $start_verse->reference;
		}else{

			return $start_verse->book->title . ' ' . $start_verse->chapter->order_by . ":" . $start_verse->order_by . "-" . preg_replace('/^[0]+/', '', substr($this->end_verse, 5));
		}

		
	}

}
