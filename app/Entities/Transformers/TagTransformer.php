<?php namespace BibleExchange\Entities\Transformers;

class TagTransformer extends Transformer{

	public function transform($tag)
	{
		
		return [
			'name'=> $tag->name
		];
		
	}
	
}