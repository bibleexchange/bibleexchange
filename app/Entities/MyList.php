<?php namespace BibleExchange\Entities;

class MyList extends \Eloquent {
	
	public static $resources  =  [
		['table'=>'audios','model'=>'Audio'],
		['table'=>'chapters','model'=>'Chapter'],
		['table'=>'questions','model'=>'Question'],
		['table'=>'users','model'=>'User'],
		['table'=>'videos','model'=>'Video']
		
		];	

}