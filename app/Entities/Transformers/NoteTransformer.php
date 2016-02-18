<?php namespace BibleExchange\Entities\Transformers;

class NoteTransformer extends Transformer{

	public function transform($note)
	{
		
		return [
				'id'=>$note->id,
				'user_id'=> $note->user_id,
				'body'	=> $note->body,
				'bible_verse_id'	=> $note->bible_verse_id,
				'created_at'	=> $note->created_at,
				'updated_at' => $note->updated_at,
				'image_id'	=> $note->image_id,
				'comments'	=> $note->comments
		];
		
	}
	
}