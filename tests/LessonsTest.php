<?php

use BibleExchange\Entities\User;
use BibleExchange\Entities\Course;
use BibleExchange\Entities\Lesson;

class LessonsTest extends ApiTester {

	/**
	 * @test
	 */	
	
	public function it_fetches_a_single_lesson()
	{
		$this->times(1)->makeLesson();
		
		$this->getJson('/api/v1/lessons/1');
		
		$this->assertResponseOk();
	}
	
		public function it_fetches_lessons()
	{
		//Arrange
		$this->times(5)->makeLesson();
		
		//Act
		$this->getJson('/api/v1/lessons');
		
		//Assert
		$this->assertResponseOk();
	}
	
	private function makeLesson($lessonFields = [])
	{
		$user = array_merge([
					'id'=>1,
					'firstname'=>$this->fake->name,
					'email'=>$this->fake->email,
					'password'=>$this->fake->randomNumber,
					'confirmed'=>1,
					'active'=>1
		]);
		User::create($user);
		
		$course = array_merge([
				'id'=>1,
				'title'=>$this->fake->name,
				'year'=>3,
				'shortname'=>'dc',
				'webReady'=>'1',
				'public'=>'1',
				'slug'=>$this->fake->slug
		]);
		Course::create($course);
		
		$lesson = array_merge([
			'title'		=>$this->fake->sentence,
			'slug'		=> $this->fake->slug,
			'content'	=> $this->fake->paragraph,
			'content_format' => $this->fake->randomElement($array = array('html','md')),
			'user_id'	=> 1,
			'course_id'	=> 1,
			'orderBy' 	=> $this->fake->randomDigitNotNull,
			'published'=> 0
		], $lessonFields);
		
		while ($this->times-- ){
			Lesson::create($lesson);
		}
		
	}
	
}
