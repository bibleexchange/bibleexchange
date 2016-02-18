<?php namespace BibleExchange\Http\Controllers;

class AdminDashboardController extends AdminController {

	/**
	 * Admin dashboard
	 *
	 */
	public function getIndex()
	{
        return view('admin.dashboard');
	}

}