<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveFromTimeFromLeaves extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leaves', function(Blueprint $table)
		{
			$table->dropColumn('from_time');      
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
			$table->time('from_time');
		});
	}

}
