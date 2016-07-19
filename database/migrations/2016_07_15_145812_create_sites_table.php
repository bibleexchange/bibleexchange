<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sites', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('name');
		  $table->string('description');
		  $table->string('email');
		  $table->integer('language_id');
		  $table->string('registration');
		  $table->string('create_lrs');
		  $table->string('restrict');
		  $table->string('domain');
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
		Schema::drop('sites');
	}

}
