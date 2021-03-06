<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveApprovedFromApprovalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('approvals', function(Blueprint $table)
		{
            $table->dropColumn('approved');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('approvals', function(Blueprint $table)
		{
			$table->enum('approved', array('YES', 'NO', 'PENDING'))->default('PENDING');
		});
	}

}
