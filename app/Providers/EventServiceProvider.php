<?php namespace BibleExchange\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use BibleExchange\Events\UserWasRegistered;
use BibleExchange\Events\UserHasConfirmedEmail;
use BibleExchange\Events\UserRequestedPasswordReset;
use BibleExchange\Events\NoteWasPublished;
use BibleExchange\Events\UserHasUpdatedProfile;
use BibleExchange\Events\UserAskedForRegistrationConfirmation;
use BibleExchange\Events\UserPasswordWasChanged;
use BibleExchange\Events\UserAmenedObject;
use BibleExchange\Events\CourseWasCreated;
use BibleExchange\Events\StudyWasCreated;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		
		UserWasRegistered::class => [
			\BibleExchange\Handlers\Events\SendRegistrationConfirmation::class,
		],

		UserHasConfirmedEmail::class => [
			\BibleExchange\Handlers\Events\SendWelcome::class,
		],
		
		UserAskedForRegistrationConfirmation::class => [
			\BibleExchange\Handlers\Events\ResendRegistrationConfirmation::class,
		],
			
		UserRequestedPasswordReset::class => [
			\BibleExchange\Handlers\Events\SendPasswordReset::class,
		],
		
		UserPasswordWasChanged::class => [
			\BibleExchange\Handlers\Events\UserPasswordWasChangedHandler::class,
		],

		/*
		 * UserHasUpdatedProfile::class => [
			
		],
		
			
		LessonWasCreated::class => [
			
		],
		
		StudyWasCreated::class => [
			
		],
		*/
		CourseWasCreated::class => [
			\BibleExchange\Handlers\Events\NotifyFollowersOfCourse::class,
		],
		NoteWasPublished::class => [
			\BibleExchange\Handlers\Events\NotifyAdminOfNote::class,
		],
		UserAmenedObject::class => [
			\BibleExchange\Handlers\Events\NotifyFollowersOfAmen::class,
		],
			
	];
	
}
