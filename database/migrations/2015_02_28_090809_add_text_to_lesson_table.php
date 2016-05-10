<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTextToLessonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lessons', function($table)
		{
			$table->integer('bible_verse_id')->unsigned(8)->nullable();
			$table->foreign('bible_verse_id')
				->references('id')->on('t_kjv')
				->onDelete('set null')
				->onUpdate('set null');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
