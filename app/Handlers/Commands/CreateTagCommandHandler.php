<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\CreateTagCommand;

use Illuminate\Queue\InteractsWithQueue;

use BibleExchange\Entities\TagRepository;
use BibleExchange\Entities\Tag;

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