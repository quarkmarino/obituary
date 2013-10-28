<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeceasedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deceased', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 16);
			$table->string('last_name', 16);
			$table->integer('age')->nullable();
			$table->date('date');
			$table->string('cause', 128)->nullable();
			$table->string('appelation', 32)->nullable();
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
		Schema::drop('deceased');
	}

}
