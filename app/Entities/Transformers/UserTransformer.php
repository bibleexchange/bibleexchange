<?php namespace BibleExperience\Entities\Transformers;

class UserTransformer extends Transformer{

	public function transform($user)
	{
		
		return [
				'be_id' => $user->id,
				'username' => $user->username,
				'avatarUrl' => 'https://graph.facebook.com/sreynoldsjr/picture',
				'profileUrl' => 'https://facebook.com/sreynoldsjr'
		];
		
	}
	
}