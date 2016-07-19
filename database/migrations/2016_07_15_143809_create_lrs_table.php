<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLrsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{//title, description,owner_id,users
		Schema::create('lrs', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('title');
		  $table->string('description');
		  $table->integer('owner_id');
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
		Schema::drop('lrs');	
	}

}
