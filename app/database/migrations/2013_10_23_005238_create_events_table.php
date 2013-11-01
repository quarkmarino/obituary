<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 128);
			$table->text('text');
			$table->string('location', 255);
			$table->datetime('datetime');
			$table->timestamps();
			$table->integer('obituary_id')->unsigned()->index();

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
		Schema::drop('events');
	}

}
