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
			$table->string('fName', 80)->nullable();
			$table->string('email', 50);
			$table->string('password', 80);
			$table->time('inTime')->nullable();
			$table->time('outTime')->nullable();
			$table->datetime('dob')->nullable();
			$table->datetime('doj')->nullable();
			$table->string('bloodGroup', 5)->nullable();
			$table->boolean('maritalStatus')->nullable();
			$table->string('phone', 15)->nullable();
			$table->string('altPhone', 15)->nullable();
			$table->text('cAddress', 200)->nullable();
			$table->text('pAddress', 200)->nullable();
			$table->integer('totalLeaves',false,3)->nullable();
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
