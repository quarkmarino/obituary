<?php
return [
  'default' => 'sqlite',

  'connections' => [
    'sqlite' => [
			'driver'   => 'sqlite',
			'database' => ':memory:',
			//'database' => __DIR__.'/../../database/test.sqlite',
			'prefix'   => '',
		],
  ]
];