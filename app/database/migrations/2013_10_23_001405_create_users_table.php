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
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('username', 16);
			$table->string('password', 64);
			$table->string('email', 18);
			$table->enum('status', ["-1", "0", "1"]);
			$table->enum('role', ["0", "1", "2", "3"]);
			$table->integer('plan_id')->nullable()->unsigned()->index()->default(null);
			$table->timestamps();

			$table->unique('username');
			$table->unique('email');

			$table->foreign('plan_id')->references('id')->on('plans')->onUpdate('cascade');
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
