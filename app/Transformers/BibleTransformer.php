<?php namespace BibleExperience\Transformers;

use Auth;

class BibleTransformer extends Transformer{

	public function transform($verse)
	{
		$user_notes = null;
		
		if(Auth::check()){
			$user_notes = Auth::user()->notes()->where('bible_verse_id', $verse->id)->orderBy('created_at','DESC')->take(3)->get();
		}
		
		return [
			'link'=> $verse->resourceURL(),
			'body'=> $verse->t,
			'user_notes'=> $user_notes
		];
		
	}

	public function transformChapter($chapter)
	{
		
		return [
			'chapter_id'=> $chapter->id,
			'chapter_orderBy'=> $chapter->orderBy,
			'book_name'=> $chapter->book->name,
			'verses'=> $chapter->verses->toJson()
		];
		
	}
	
}