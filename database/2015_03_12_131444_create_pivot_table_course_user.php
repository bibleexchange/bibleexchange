<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableCourseUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_user', function(Blueprint $table)
		{

			$table->increments('id');
			$table->integer('course_id')->index()->unsigned();
			$table->integer('user_id')->index()->unsigned();
			
			$table->foreign('course_id')
				->references('id')->on('courses')
				->onDelete('cascade')
				->onUpdate('cascade');
				
			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade')
				->onUpdate('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course_user', function(Blueprint $table)
		{
			//
		});
	}

}
