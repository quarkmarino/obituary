<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateObituariesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('obituaries', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 64)->nullable();
			$table->enum('status', ["-1", "0", "1"]);
			$table->text('article');
			$table->enum('religion', ["-1", "-2", "-3", "-4", "-5"])->nullable()->default(null);
			$table->date('term_limit');
			$table->enum('style', ["0", "1", "2", "3", "4", "5"])->default(0);
			$table->integer('deceased_id')->unsigned()->index();
			$table->integer('promoter_id')->unsigned()->index();
			$table->integer('owner_id')->unsigned()->nullable()->index();
			$table->timestamps();

			$table->foreign('deceased_id')->references('id')->on('deceased')->onUpdate('cascade');
			$table->foreign('promoter_id')->references('id')->on('users')->onUpdate('cascade');
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
		Schema::drop('obituaries');
	}

}
