<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\CreateTagCommand;

use Illuminate\Queue\InteractsWithQueue;

use BibleExperience\TagRepository;
use BibleExperience\Tag;

class CreateTagCommandHandler {

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
	 * @param  Tag  $command
	 * @return void
	 */
public function handle(CreateTagCommand $command)
	{
		$tag = Tag::make(
				$command->name
		);

		$this->repository->save($tag);
		 
		//\Event::fire(new TagWasCreated($tag));

		return $tag;
	}

}