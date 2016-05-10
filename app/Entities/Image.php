<?php namespace BibleExchange\Entities;

class Image extends \Eloquent {
	
	protected $fillable = ['name','src','alt_text','created_at','updated_at','bible_verse_id'];
	
	public static function lessons(){
		
		return $this->hasMany('BibleExchange\Entities\Lesson');
	}
	
	public function studies(){
	
		return $this->hasMany('BibleExchange\Entities\Study');
	}
	
	public function verse(){
	
		return $this->belongsTo('BibleExchange\Entities\BibleVerse','bible_verse_id');
	}
	
	public static function upload($file, $model, $user){
		
		if ($file->isValid()){
		
			//Get Unique String
			$uuid = str_replace([' ','.'],'',microtime());
		
			//Place Image
			$destinationPath = public_path().'/images/uploads'; // upload path
			$extension = $file->getClientOriginalExtension(); // getting image extension
			$fileName = $uuid.'.'.$extension; // renaming image
			$file->move($destinationPath, $fileName); // uploading file to given path
		
			//Enter Image into Database
			$dbImage = new self;
			$dbImage->name = $uuid.'.'.$extension;
			$dbImage->src = url('/images/uploads/'.$fileName);
			$dbImage->alt_text = $model->present()->title;
			$dbImage->bible_verse_id = $model->mainVerse ? $model->mainVerse->id : null;
			$dbImage->user_id = $user->id;
			$dbImage->save();
		
			return $dbImage->id;
		}
		
		Flash::error('File couldn\'t be uploaded');
		
		return Redirect::back();
		
	}
	
	public static function defaultImage(){
		$image = new \stdClass();
		$image->src = 'http://bible.exchange/images/be_logo.png';
		$image->name = 'Bible exchange';
		$image->alt_text = 'Bible exchange';
		return $image;
	}

}