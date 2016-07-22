<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkedServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('linked_services', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('user_id')->index()->unsigned();
			$table->integer('store_id')->index()->unsigned();
			
			$table->string('auth_token');
			
			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade')
				->onUpdate('cascade');
				
			$table->foreign('store_id')
				->references('id')->on('stores')
				->onDelete('cascade')
				->onUpdate('cascade');
			
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
		Schema::drop('linked_services');
	}

}
