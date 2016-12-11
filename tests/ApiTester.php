<?php

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTester extends TestCase {
	
	protected $fake;
	
	function __construct()
	{
		$this->fake = Faker::create();
	}
	
	public function setUp()
	{
		parent::setUp();
		
		Artisan::call('migrate');
	}
	
	public function times($count){
		
		$this->times = $count;
		
		return $this;
	}
	
	public function getJson($uri){
		return json_decode($this->call('GET',$uri)->getContent());
	}
}
