<?php namespace BibleExchange\Entities\Transformers;

class AmenTransformer extends Transformer{

	public function transform($amen)
	{
		
		return [
				'id'			=> $amen->id,
				'user_id'		=> $amen->user_id,
				'amenable_id'	=> $amen->amenable_id,
				'amenable_type'	=> $amen->amenable_type,
				'created_at'	=> $amen->created_at,
				'updated_at' 	=> $amen->updated_at
		];
		
	}
	
}