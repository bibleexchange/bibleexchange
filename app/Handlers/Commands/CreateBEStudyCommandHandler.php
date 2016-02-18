<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\CreateBEStudyCommand;

use Illuminate\Queue\InteractsWithQueue;

use BibleExchange\Events\StudyWasCreated;
use BibleExchange\Entities\StudyRepository;
use BibleExchange\Entities\Revision;
use BibleExchange\Entities\Study;
use BibleExchange\Entities\Text;

class CreateBEStudyCommandHandler {

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
	public function handle(CreateBEStudyCommand $command)
	{
				
		$text = Text::make($command->text);
		$text->save();

		$study = Study::make(
				$command->description,
				$text->id,
           		$command->namespace_id, 
				$command->title,
				0,//is published
				$command->user_id
        );

    	$this->repository->save($study);
    	
        \Event::fire(new StudyWasCreated($study));
        
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