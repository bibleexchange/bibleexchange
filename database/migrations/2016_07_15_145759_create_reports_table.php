<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{//['name', 'description', 'query', 'lrs_id', 'since', 'until'];
		Schema::create('reports', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('description');
		  $table->string('query');
		  $table->integer('lrs_id')->unsigned();
		  $table->string('since');
		  $table->string('until');
		  $table->foreign('lrs_id')->references('id')->on('lrs');
		  
		});
	}

	public function down()
	{
		Schema::drop('reports');	
	}


}
