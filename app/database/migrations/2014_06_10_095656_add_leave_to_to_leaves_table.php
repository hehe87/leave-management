<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLeaveToToLeavesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leaves', function(Blueprint $table)
		{
			$table->date('leave_to')->after('leave_date')->nullable()->default(NULL);
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
			$table->dropColumn('leave_to');
		});
	}

}
