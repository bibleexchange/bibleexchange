<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

public function up()
	{//['authority', 'description', 'api', 'lrs_id', 'scopes'];
		Schema::create('clients', function(Blueprint $table) {
		  $table->increments('id');
		  $table->string('authority');
		  $table->string('description');
		  $table->string('api');
		  $table->integer('lrs_id')->unsigned();
		  $table->string('scopes');
		  $table->timestamps();
		  
		  $table->foreign('lrs_id')->references('id')->on('lrs');
		  
		});
		
		    
		
	}

	public function down()
	{
		Schema::drop('clients');	
	}

}
