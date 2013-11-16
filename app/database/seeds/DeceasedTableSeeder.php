<?php

class DeceasedTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('deceaseds')->truncate();

		$deceased = [
			[
				'name' => 'fulanito',
				'last_name' => 'perez',
				'date' => '2011-03-06',
				'mortuary_id' => 1,
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			],
			[
				'name' => 'sutanito',
				'last_name' => 'lopez',
				'date' => '2010-06-04',
				'mortuary_id' => 2,
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			],
		];

		// Uncomment the below to run the seeder
		DB::table('deceased')->insert($deceased);
	}

}
