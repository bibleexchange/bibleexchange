<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyTaskTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('study_task', function(Blueprint $table)
		{

			$table->increments('id');
			$table->integer('study_id')->index()->unsigned();
			$table->integer('task_id')->index()->unsigned();
			
			$table->foreign('study_id')
				->references('id')->on('studies')
				->onDelete('cascade')
				->onUpdate('cascade');
				
			$table->foreign('task_id')
				->references('id')->on('tasks')
				->onDelete('cascade')
				->onUpdate('cascade');
			
			$table->timeStamps();
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('study_task', function(Blueprint $table)
		{
			//
		});
	}

}
