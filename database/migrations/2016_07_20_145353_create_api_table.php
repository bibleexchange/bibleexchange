<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	
public function up()
	{//['basic_key','basic_secret','client_id'];
		Schema::create('api', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('basic_key');
		  $table->string('basic_secret');
		  $table->integer('client_id')->unsigned();
		  $table->timestamps();
		  
		  $table->foreign('client_id')->references('id')->on('clients');
		  
		});
		
		    
		
	}

	public function down()
	{
		Schema::drop('api');	
	}


}
