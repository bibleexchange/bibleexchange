<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\CreateBibleNoteCommand;
use Illuminate\Queue\InteractsWithQueue;
use BibleExchange\Entities\NoteRepository;
use BibleExchange\Entities\Note;

class CreateBibleNoteCommandHandler {
	
	private $noteRepository;
	
	/**
	 * Create the command handler.
	 *
	 * @return void
	 */
	public function __construct(NoteRepository $noteRepository)
	{
		$this->noteRepository = $noteRepository;
	}

	/**
	 * Handle the command.
	 *
	 * @param  CreateBibleNoteCommand  $command
	 * @return void
	 */
	public function handle(CreateBibleNoteCommand $command)
	{		
		$note = Note::publish($command->bible_verse_id, $command->body, $command->image_id);
	
		$note = $this->noteRepository->save($note, $command->userId);
	
		return $note;
	}
}
