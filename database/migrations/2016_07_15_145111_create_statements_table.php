<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
  
	public function up()
	{
		Schema::create('statements', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('statement');
		  $table->string('active');
		  $table->string('voided');	
		  $table->string('refs');
		  $table->integer('lrs_id');
		  $table->string('stored');
		  $table->string('timestamp');
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
		Schema::drop('statements');
	}


}
