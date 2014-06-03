<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApprovalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('approvals', function(Blueprint $table)
		{
			$table->increments('id');			
			$table->integer('approver_id')->unsigned();
			$table->foreign('approver_id')->references('id')->on('users');
			$table->integer('leave_id')->unsigned();
			$table->foreign('leave_id')->references('id')->on('leaves');
			$table->boolean('approved');
			$table->text('approval_note')->nullable();
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
		Schema::drop('approvals');
	}

}
