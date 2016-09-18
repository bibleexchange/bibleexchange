<?php namespace BibleExperience;

use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\AmenableTrait;
use BibleExperience\Core\CommentableTrait;
use BibleExperience\User;

class Note extends \Eloquent {

	//protected $connection = 'mysql';

    use PresentableTrait, AmenableTrait, CommentableTrait;

    /**
     * Fillable fields for a new note.
     *
     * @var array
     */
    protected $fillable = ['body','bible_verse_id','image_id','user_id','created_at','updated_at'];
    protected $appends = ['tags','properties','author'];

    /**
     * Path to the presenter for a note.
     *
     * @var string
     */
    protected $presenter = 'BibleExperience\Presenters\NotePresenter';

	/**
     * Always capitalize the first name when we retrieve it
     */
    public function getDISABLEDBodyAttribute($value) {
        return JSON_DECODE($value);
    }

    public function getDates()
    {
        return ['created_at', 'updated_at', 'sent_at'];
    }

    public function withBody($body)
    {
    	$this->body = $body;

    	return $this;
    }

	public function notebooks()
	{
		return $this->belongsToMany('\BibleExperience\Notebook')->orderBy('orderBy','ASC')->orderBy('created_at','ASC');
	}

    public function isCreator($user){

    	if($this->author->id === $user->id){
    		return true;
    	}

    	return false;
    }

    public function verse()
    {
    	return $this->belongsTo('BibleExperience\BibleVerse','bible_verse_id');
    }

    public function url()
    {
    	return url('@' . $this->author->username . '/notes/' . $this->id);
    }

    public function editUrl()
    {
    	return null;
    }

    public function fbShareUrl()
    {
    	return url('@' . $this->author->username . '/notes/' . $this->id);
    }

    public function hint()
    {
    	return '"'.substr(strip_tags($this->body),0,64).'..." '.$this->verse->reference;
    }

    /**
     * Publish a new note.
     *
     * @param $body
     * @return static
     */
    public static function publish($bible_verse_id, $body, $image_id)
    {
    	$body = strip_tags($body);

        $note = new static(compact('bible_verse_id','body','image_id'));

        return $note;
    }

    public function image()
    {
    	return $this->belongsTo('BibleExperience\Image');
    }

    public function defaultImageUrl()
    {

    	if($this->image === null){

    		return 'http://bible.exchange/images/be_logo.png';
    	}

    	return url($this->image->src);

    }

    public function getTagsAttribute()
    {
		if(isset($this->body->tags)){
			$array = explode('#',$this->body->tags);
			unset($array[0]);
			$tags = implode(',',$array);
		}else {
			$tags = [];
		}

    	return $tags;
    }

    public function getPropertiesAttribute()
    {
    	$props = json_decode($this->body);
	    $props->tags = array_filter(explode("#",$props->tags));
	    return $props;
    }

    public function getAuthorAttribute()
    {
    	return User::find($this->user_id);
    }

}
