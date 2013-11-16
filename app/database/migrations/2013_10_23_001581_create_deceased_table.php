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
			$table->integer('mortuary_id')->unsigned()->index();
			$table->integer('cemetery_id')->unsigned()->nullable()->index();
			$table->timestamps();

			$table->foreign('mortuary_id')->references('id')->on('mortuaries')->onUpdate('cascade');
			$table->foreign('cemetery_id')->references('id')->on('cemeteries')->onUpdate('cascade');
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
