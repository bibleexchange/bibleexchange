<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\CreateLessonCommand;

use Illuminate\Queue\InteractsWithQueue;

use BibleExchange\Events\LessonWasCreated;
use BibleExchange\Entities\LessonRepository;
use BibleExchange\Entities\Lesson;

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