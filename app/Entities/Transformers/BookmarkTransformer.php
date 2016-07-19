<?php namespace BibleExperience\Entities\Transformers;

class BookmarkTransformer extends Transformer{

	public function transform($tag)
	{
		
		return [
			'url'=> $tag->url,
			'created'=>$tag->present()->created_at
		];
		
	}
	
}