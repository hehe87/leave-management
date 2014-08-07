<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveToTimeFromLeaves extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leaves', function(Blueprint $table)
		{
			$table->dropColumn('to_time');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('leaves', function(Blueprint $table)
		{
			$table->time('to_time')->nullable();
		});
	}

}
