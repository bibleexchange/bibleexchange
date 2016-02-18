<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexAndForeignKeyBbible extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('audios', function($table)
		{
			
			$table->integer('bible_verse_id')->unsigned(8)->nullable();
			
			$table->foreign('bible_verse_id')
				->references('id')->on('t_kjv')
				->onDelete('set null')
				->onUpdate('cascade');
				
			$table->dropColumn('bible');
			
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
