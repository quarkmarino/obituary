<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('users')->truncate();

		$users = [
			[
				'username' => 'admin',
				'password' => Hash::make('admin_password'),
				'email' => 'admin@obituaries.com',
				'status' => 1,
				'role' => 3,
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			],
			[
				'username' => 'guest',
				'password' => Hash::make('no_password'),
				'email' => 'guest@obituaries.com',
				'status' => 1,
				'role' => 0,
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			],
			[
				'username' => 'promoter',
				'password' => Hash::make('promoter_password'),
				'email' => 'promoter@obituaries.com',
				'status' => 1,
				'role' => 2,
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			],
			[
				'username' => 'client',
				'password' => Hash::make('client_password'),
				'email' => 'client@obituaries.com',
				'status' => 1,
				'role' => 1,
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			],
		];

		// Uncomment the below to run the seeder
		DB::table('users')->insert($users);
	}
	//þ
}
