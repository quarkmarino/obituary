<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMemoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('memories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('url', 255)->nullable();
			$table->string('file', 255)->nullable();
			$table->text('comment')->nullable();
			$table->date('date')->nullable();
			$table->enum('type', ["0", "1"])->default(0);
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
		Schema::drop('memories');
	}

}
