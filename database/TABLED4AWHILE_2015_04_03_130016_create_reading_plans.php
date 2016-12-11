<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingPlans extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reading_plans', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->unsigned();
			$table->integer('start_verse')->unsigned();
			$table->integer('end_verse')->unsigned();
			$table->integer('verses_count')->unsigned();
			$table->integer('verses_read')->unsigned();
			$table->date('end_date')->unsigned();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reading_plans', function(Blueprint $table)
		{
			//
		});
	}

}
