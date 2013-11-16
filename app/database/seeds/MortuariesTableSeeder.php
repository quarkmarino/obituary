<?php

class MortuariesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('mortuaries')->truncate();

		$mortuaries = [
			[
				'name' => 'diaz',
				'location' => 'Av. Independencia 202',
				'owner_id' => 3,
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			],
			[
				'name' => 'centro',
				'location' => 'Av. Juaréz 606',
				'owner_id' => 3,
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			],
		];

		// Uncomment the below to run the seeder
		DB::table('mortuaries')->insert($mortuaries);
	}

}
