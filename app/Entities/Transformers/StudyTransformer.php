<?php namespace BibleExchange\Entities\Transformers;

class StudyTransformer extends Transformer{

	public function transform($study)
	{
		
		return [
				'app_id'=> $study->id,
				'title'=> $study->title,
				'owner'	=> $study->creator->fullname,
				'article' => $study->published_html,
				'updated' => $study->lastChangeWasMade,
				'comments'=> $study->comments
		];
		
	}
	
}