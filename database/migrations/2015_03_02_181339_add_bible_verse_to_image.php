<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBibleVerseToImage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('images', function($table)
		{
			$table->integer('bible_verse_id')->unsigned(8)->nullable();
			$table->foreign('bible_verse_id')
				->references('id')->on('t_kjv')
				->onDelete('set null')
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
		//
	}

}
