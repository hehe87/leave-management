<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 80);
			$table->string('fName', 80);
			$table->string('email', 50);
			$table->string('password', 80);
			$table->time('inTime');
			$table->time('outTime');
			$table->datetime('dob');
			$table->datetime('doj');
			$table->string('bloodGroup', 5);
			$table->boolean('maritalStatus');
			$table->string('phone', 15);
			$table->string('altPhone', 15);
			$table->text('cAddress', 200);
			$table->text('pAddress', 200);
			$table->integer('totalLeaves',false,3);
			$table->enum('employeeType', array("EMPLOYEE","ADMIN"));
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
		Schema::drop('users');
	}

}
