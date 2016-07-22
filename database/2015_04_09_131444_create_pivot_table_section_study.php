<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableSectionStudy extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('section_study', function(Blueprint $table)
		{

			$table->increments('id');
			$table->integer('section_id')->index()->unsigned();
			$table->integer('study_id')->index()->unsigned();
			
			$table->foreign('section_id')
				->references('id')->on('sections')
				->onDelete('cascade')
				->onUpdate('cascade');
				
			$table->foreign('study_id')
				->references('id')->on('studies')
				->onDelete('cascade')
				->onUpdate('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('section_study', function(Blueprint $table)
		{
			//
		});
	}

}
