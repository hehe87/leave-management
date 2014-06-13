<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExtraleavesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('extraleaves', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('leaves_count');
			$table->integer('for_year');
			$table->date('from_date');
			$table->date('to_date');
			$table->string('description');
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
		Schema::drop('extraleaves');
	}

}
