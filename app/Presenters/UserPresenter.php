<?php namespace BibleExchange\Presenters;

class UserPresenter extends Presenter {

    /**
     * Present a link to the user's gravatar
     *
     * @param int $size
     * @return string
     */
    public function gravatar($size = 30)
    {
        
		if ($this->profile_image !== NULL)
		{
			return $this->profile_image.'?w='.$size.'&h='.$size;
		}
		
		$email = md5($this->email);

        return "//www.gravatar.com/avatar/{$email}?s={$size}&d=identicon";
    }

    /**
     * @return string
     */
    public function followerCount()
    {
        $count = $this->entity->followers()->count();
        $plural = str_plural('Follower', $count);

        return "{$count} {$plural}";
    }

    /**
     * @return string
     */
    public function statusCount()
    {
        $count = $this->entity->notes()->count();
        $plural = str_plural('Note', $count);

        return "{$count} {$plural}";
    }

}