<?php namespace BibleExchange\Entities;

use BibleExchange\Entities\User;
use BibleExchange\Entities\BibleVerse;
use BibleExchange\Events\NoteWasPublished;

class NoteRepository {

    /**
     * Get all notes associated with a user.
     *
     * @param User $user
     * @return mixed
     */
    public function getAllForUser(User $user, $limit = 5)
    {
        return $user->notes()->with('user')->latest()->paginate($limit);
    }

    /**
     * Get the feed for a user.
     *
     * @param User $user
     * @return mixed
     */
    public function getFeedForUser(User $user, $perPage= 5)
    {
        $userIds = $user->followedUsers()->lists('followed_id');
        $userIds[] = $user->id;

        return Note::with('comments')->whereIn('user_id', $userIds)->latest()->paginate($perPage);
    }
	
	public function getFeedForUserWhereVerse(User $user, BibleVerse $verse, $limit = 5)
    {
        $userIds = $user->followedUsers()->lists('followed_id');
        $userIds[] = $user->id;
		
        return Note::with('comments')->whereIn('user_id', $userIds)->where('bible_verse_id',$verse->id)->latest()->paginate($limit);
    }
	
	public function getFeedForPublicNotesWhereVerse(BibleVerse $verse)
    {
        //a quick hack, should make this more dynamic in the future
		$userIds = ['1','2','3','18'];
		
        return Note::with('comments')->whereIn('user_id', $userIds)->where('bible_verse_id',$verse->id)->latest()->get();
    }
	
	public function getFeedForUserWhereVerses(User $user, array $verses, $limit = 5)
    {

		$userIds = $user->followedUsers()->lists('followed_id');
        $userIds[] = $user->id;

        return Note::with('comments')->whereIn('user_id', $userIds)->whereIn('bible_verse_id',$verses)->latest()->paginate($limit);
    }
	
    public function getFeedForPublicNotesWhereVerses(array $verses, $limit = 5)
    {		
    	 //a quick hack, should make this more dynamic in the future
		$userIds = ['1','2','3','18'];
        return Note::with('comments')->whereIn('user_id', $userIds)->whereIn('bible_verse_id',$verses)->latest()->paginate($limit);
     }
	
    /**
     * Save a new note for a user.
     *
     * @param Note $note
     * @param $userId
     * @return mixed
     */
    public function save(Note $note, $userId)
    {
    	
    	$created_note = User::findOrFail($userId)
            ->notes()
            ->save($note);
    	
    	\Event::fire(new NoteWasPublished($created_note));
    	
    	return $created_note;
    }

    /**
     * @param $userId
     * @param $noteId
     * @param $body
     * @return Comment
     */
    public function leaveComment($userId, $noteId, $body)
    {
        $comment = Comment::leave($body, $noteId);

        User::findOrFail($userId)->comments()->save($comment);

        return $comment;
    }

} 