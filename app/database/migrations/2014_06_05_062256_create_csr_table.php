<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCsrTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('csr', function(Blueprint $table)
		{
			$table->increments('id');
      $table->integer('leave_id')->unsigned();
			$table->foreign('leave_id')->references('id')->on('leaves');
			$table->time('from_time');
			$table->time('to_time');
			$table->text('completion_note')->nullable();
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
		Schema::drop('csr');
	}

}
