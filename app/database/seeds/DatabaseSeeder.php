<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('PlansTableSeeder');
		$this->call('CemeteriesTableSeeder');
		$this->call('DeceasedTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('MortuariesTableSeeder');
		$this->call('ObituariesTableSeeder');
		$this->call('EventsTableSeeder');
		$this->call('CondolencesTableSeeder');
		$this->call('ImagesTableSeeder');
	}

}