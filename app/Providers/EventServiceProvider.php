<?php namespace BibleExperience\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use BibleExperience\Events\UserWasRegistered;
use BibleExperience\Events\UserHasConfirmedEmail;
use BibleExperience\Events\UserRequestedPasswordReset;
use BibleExperience\Events\NoteWasPublished;
use BibleExperience\Events\UserHasUpdatedProfile;
use BibleExperience\Events\UserAskedForRegistrationConfirmation;
use BibleExperience\Events\UserPasswordWasChanged;
use BibleExperience\Events\UserAmenedObject;
use BibleExperience\Events\CourseWasCreated;
use BibleExperience\Events\StudyWasCreated;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		
		UserWasRegistered::class => [
			\BibleExperience\Handlers\Events\SendRegistrationConfirmation::class,
		],

		UserHasConfirmedEmail::class => [
			\BibleExperience\Handlers\Events\SendWelcome::class,
		],
		
		UserAskedForRegistrationConfirmation::class => [
			\BibleExperience\Handlers\Events\ResendRegistrationConfirmation::class,
		],
			
		UserRequestedPasswordReset::class => [
			\BibleExperience\Handlers\Events\SendPasswordReset::class,
		],
		
		UserPasswordWasChanged::class => [
			\BibleExperience\Handlers\Events\UserPasswordWasChangedHandler::class,
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
			\BibleExperience\Handlers\Events\NotifyFollowersOfCourse::class,
		],
		NoteWasPublished::class => [
			\BibleExperience\Handlers\Events\NotifyAdminOfNote::class,
		],
		UserAmenedObject::class => [
			\BibleExperience\Handlers\Events\NotifyFollowersOfAmen::class,
		],
			
	];
	
}
