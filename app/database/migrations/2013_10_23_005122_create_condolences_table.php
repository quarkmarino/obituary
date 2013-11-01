<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCondolencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('condolences', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 32);
			$table->string('email', 18);
			$table->text('message');
			$table->enum('offering', ["0", "1", "2", "3", "4"])->default(0);
			$table->enum('status', ["-1", "0", "1"])->default(0);
			$table->integer('obituary_id')->unsigned()->index();
			$table->timestamps();

			$table->foreign('obituary_id')->references('id')->on('obituaries')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('condolences');
	}

}
