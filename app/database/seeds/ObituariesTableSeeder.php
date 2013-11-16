<?php

class ObituariesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('obituaries')->truncate();

		$obituaries = [
			[
				'title' => 'My Insightful Article',
				'status' => 1,
				'article' => 'Bacon ipsum dolor sit amet esse duis pastrami anim, pancetta fatback capicola officia tenderloin. Meatloaf culpa ut, bacon sed sausage jerky cillum est ham ad laboris ham hock dolore. Venison ut enim, aliqua elit frankfurter et incididunt consequat culpa nostrud in. Ground round venison commodo do capicola. Id commodo laborum proident nostrud cillum duis shoulder. Shank spare ribs pastrami, jowl jerky eiusmod proident tongue occaecat enim doner pancetta capicola t-bone.',
				'deceased_id' => 1,
				'promoter_id' => 3,
				'term_limit' => 'CURRENT_DATE',
				'created_at' => 'CURRENT_TIMESTAMP',
				'updated_at' => 'CURRENT_TIMESTAMP'
			]
		];

		// Uncomment the below to run the seeder
		DB::table('obituaries')->insert($obituaries);
	}

}
