<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUrlShorts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('url_shorts', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('url', 64);
            $table->integer('shortable_id')->unsigned();
            $table->string('shortable_type', 128);
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
		Schema::table('url_shorts', function(Blueprint $table)
		{
			//
		});
	}

}
