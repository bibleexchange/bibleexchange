<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\UpdateBEStudyCommand;

use Illuminate\Queue\InteractsWithQueue;

use BibleExchange\Events\StudyWasCreated;
use BibleExchange\Entities\StudyRepository;
use BibleExchange\Entities\Revision;
use BibleExchange\Entities\Study;
use BibleExchange\Entities\Text;

class UpdateBEStudyCommandHandler {

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @param UserRepository $repository
     */
    function __construct(StudyRepository $study)
    {
        $this->repository = $study;
    }

	/**
	 * Handle the command.
	 *
	 * @param  CreateLessonCommand  $command
	 * @return void
	 */
	public function handle(UpdateBEStudyCommand $command)
	{
				
		$text = Text::make($command->text);
		$text->save();
		
		$study = $command->study;
		$study->latest_text_id = $text->id;
		$study->is_published = 0;
    	$this->repository->save($study);
        
        $revision = Revision::make(	$study->id, 
        							$text->id, 
        							$command->comment, 
        							$command->user_id, 
        							$command->minor_edit, 
        							str_word_count(strip_tags($command->text)
        							));
        $revision->save();

        return $study;
	}

}