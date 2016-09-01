<?php namespace BibleExperience;

use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\AmenableTrait;
use BibleExperience\Core\CommentableTrait;

class Note extends \Eloquent {
	
	//protected $connection = 'mysql';
	
    use PresentableTrait, AmenableTrait, CommentableTrait;

    /**
     * Fillable fields for a new note.
     *
     * @var array
     */
    protected $fillable = ['body','bible_verse_id','image_id','user_id','object_id','object_type'];
    
    protected $appends = array('tags','relatedObject','properties');
    
    /**
     * Path to the presenter for a note.
     *
     * @var string
     */
    protected $presenter = 'BibleExperience\Presenters\NotePresenter';
	
	private $relatedObject = null;
	private $type_root = "BibleExperience\\";
	
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
    
    public function regarding($object)
    {
    	if(is_object($object))
    	{
    		$this->object_id   = $object->id;
    		$this->object_type = get_class($object);
    	}
    
    	return $this;
    }
    
    public function hasValidObject()
    {
		
    	try
    	{		
			switch($this->object_type){
				case 'Recording':
					$object = \BibleExperience\Recording::where('id',$this->object_id)->with('formats')->get();
				break;
				
				default:
					$object = call_user_func_array($this->type_root.$this->object_type . '::findOrFail', [$this->object_id]);
				break;
			}
			
    	}
    	catch(\Exception $e)
    	{
			return false;
    	}
    
    	$this->relatedObject = $object;
		
    	return true;
    }
    
    public function getObject()
    {
		
		if($this->relatedObject !== null){

		}

		if(!$this->relatedObject)
    	{
    		$hasObject = $this->hasValidObject();

    		if(!$hasObject)
    		{
    			if($this->object_type !== null){
					throw new \Exception(sprintf("No valid object (%a with ID %b) associated with this note.", $this->type_root.$this->object_type, $this->object_id));
				}else{
					
					$collection = new \Illuminate\Database\Eloquent\Collection;					
					return $collection;
				}
    		}
    	}
    
    	return $this->relatedObject;
    }
	
	public function notebooks()
	{
		return $this->belongsToMany('\BibleExperience\Notebook')->orderBy('orderBy','ASC')->orderBy('created_at','ASC');
	}
	
    /**
     * A note belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo('BibleExperience\User');
    }
	
    public function isCreator($user){
    
    	if($this->user->id === $user->id){
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
    	return url('@' . $this->user->username . '/notes/' . $this->id);
    }
    
    public function editUrl()
    {
    	return null;
    }
    
    public function fbShareUrl()
    {
    	return url('@' . $this->user->username . '/notes/' . $this->id);
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
	
	public function getRelatedObjectAttribute()
    {
    	return $this->getObject();
    }
	
	public function getPropertiesAttribute()
    {
    	return json_decode($this->body);
    }
	
}