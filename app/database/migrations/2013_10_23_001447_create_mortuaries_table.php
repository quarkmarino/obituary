<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMortuariesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mortuaries', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 45);
			$table->string('location', 255);
			$table->integer('owner_id')->unsigned()->index();
			$table->timestamps();

			$table->foreign('owner_id')->references('id')->on('users')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mortuaries');
	}

}
