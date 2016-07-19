<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLrsUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lrs_users', function(Blueprint $table) {
		  $table->increments('id');
		  $table->integer('lrs_id');
		  $table->integer('user_id');
		  $table->integer('role_id');	
		  $table->index('lrs_id');
		  $table->index('user_id');
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
		Schema::drop('lrs_users');
	}

}
