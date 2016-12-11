<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\CreateLessonCommand;

use Illuminate\Queue\InteractsWithQueue;

use BibleExperience\Events\LessonWasCreated;
use BibleExperience\LessonRepository;
use BibleExperience\Lesson;

class CreateLessonCommandHandler {

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @param UserRepository $repository
     */
    function __construct(LessonRepository $lesson)
    {
        $this->repository = $lesson;
    }

	/**
	 * Handle the command.
	 *
	 * @param  CreateLessonCommand  $command
	 * @return void
	 */
	public function handle(CreateLessonCommand $command)
	{
		$lesson = Lesson::make(
           		$command->title, 
				$command->user_id, 
				$command->slug, 
				$command->content
        );

    	$this->repository->save($lesson);
    	
        \Event::fire(new LessonWasCreated($lesson));
        
        return $lesson;
	}

}