<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;

class UserNotificationsController extends Controller {

	function __construct()
	{
	
		$this->middleware('auth');
	
		$this->currentUser = Auth::user();
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$notifications_all = new \BibleExchange\Entities\NotificationFetcher($this->currentUser);
		
		$notifications = $notifications_all->fetch();
		
		$unread_count = $notifications_all->onlyUnread()->fetch()->count();

		return view('users.notifications.index',compact('notifications','unread_count'));
	}

	/**
	 * Mark Notifications as being read.
	 *
	 * @return Response
	 */
	public function userReadNotifications()
	{
		$notifications = new \BibleExchange\Entities\NotificationFetcher($this->currentUser);
		
		foreach($notifications->onlyUnread()->fetch(false) AS $n)
		{
			$n->is_read = 1;
			$n->save();
		}
		
		return \Redirect::to('/');
	}

}
