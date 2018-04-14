<?php

return [

	/*
	|--------------------------------------------------------------------------
	| PDO Fetch Style
	|--------------------------------------------------------------------------
	|
	| By default, database results will be returned as instances of the PHP
	| stdClass object; however, you may desire to retrieve records in an
	| array format for simplicity. Here you can tweak the fetch style.
	|
	 */

	'fetch' => PDO::FETCH_CLASS,

	/*
	|--------------------------------------------------------------------------
	| Default Database Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the database connections below you wish
	| to use as your default connection for all database work. Of course
	| you may use many connections at once using the Database library.
	|
	 */

	'default' => env('DB_CONNECTION', 'pgsql'),

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	 */

	'connections' => [

		'sqlite'    => [
			'driver'   => 'sqlite',
			'database' => storage_path('database.sqlite'),
			'prefix'   => '',
		],

		'mysql'      => [
			'driver'    => 'mysql',
			'host'      => env('DB_HOST', 'localhost'),
			'database'  => env('DB_DATABASE', 'forge'),
			'username'  => env('DB_USERNAME', 'forge'),
			'password'  => env('DB_PASSWORD', ''),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => false,
		],

		'pgsql'     => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
		],

		'pss'       => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'pss',
		],

		'beneficiarios' => [
			'driver'       => 'pgsql',
			'host'         => env('DB_HOST', 'localhost'),
			'database'     => env('DB_DATABASE', 'forge'),
			'username'     => env('DB_USERNAME', 'forge'),
			'password'     => env('DB_PASSWORD', ''),
			'charset'      => 'utf8',
			'prefix'       => '',
			'schema'       => 'beneficiarios',
		],

		'sistema'   => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'sistema',
		],

		'efectores' => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'efectores',
		],

		'solicitudes' => [
			'driver'     => 'pgsql',
			'host'       => env('DB_HOST', 'localhost'),
			'database'   => env('DB_DATABASE', 'forge'),
			'username'   => env('DB_USERNAME', 'forge'),
			'password'   => env('DB_PASSWORD', ''),
			'charset'    => 'utf8',
			'prefix'     => '',
			'schema'     => 'solicitudes',
		],

		'puco'      => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'puco',
		],

		'fondos'    => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'fondos',
		],

		'prestaciones' => [
			'driver'      => 'pgsql',
			'host'        => env('DB_HOST', 'localhost'),
			'database'    => env('DB_DATABASE', 'forge'),
			'username'    => env('DB_USERNAME', 'forge'),
			'password'    => env('DB_PASSWORD', ''),
			'charset'     => 'utf8',
			'prefix'      => '',
			'schema'      => 'prestaciones',
		],

		'hcd'       => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'hcd',
		],

		'comprobantes' => [
			'driver'      => 'pgsql',
			'host'        => env('DB_HOST', 'localhost'),
			'database'    => env('DB_DATABASE', 'forge'),
			'username'    => env('DB_USERNAME', 'forge'),
			'password'    => env('DB_PASSWORD', ''),
			'charset'     => 'utf8',
			'prefix'      => '',
			'schema'      => 'comprobantes',
		],

		'ddjj'      => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'ddjj',
		],

		'indicadores' => [
			'driver'     => 'pgsql',
			'host'       => env('DB_HOST', 'localhost'),
			'database'   => env('DB_DATABASE', 'forge'),
			'username'   => env('DB_USERNAME', 'forge'),
			'password'   => env('DB_PASSWORD', ''),
			'charset'    => 'utf8',
			'prefix'     => '',
			'schema'     => 'indicadores',
		],

		'odp'       => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'odp',
		],

		'geo'       => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'geo',
		],

		'trazadoras' => [
			'driver'    => 'pgsql',
			'host'      => env('DB_HOST', 'localhost'),
			'database'  => env('DB_DATABASE', 'forge'),
			'username'  => env('DB_USERNAME', 'forge'),
			'password'  => env('DB_PASSWORD', ''),
			'charset'   => 'utf8',
			'prefix'    => '',
			'schema'    => 'trazadoras',
		],

		'tablero'   => [
			'driver'   => 'pgsql',
			'host'     => env('DB_HOST', 'localhost'),
			'database' => env('DB_DATABASE', 'forge'),
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'tablero',
		],

		'datawarehouse' => [
			'driver'       => 'pgsql',
			'host'         => env('DB_HOST_DW', 'localhost'),
			'database'     => env('DB_DATABASE_DW', 'forge'),
			'username'     => env('DB_USERNAME_DW', 'forge'),
			'password'     => env('DB_PASSWORD_DW', ''),
			'charset'      => 'utf8',
			'prefix'       => '',
			'schema'       => 'public',
		],

		'sqlsrv'    => [
			'driver'   => 'sqlsrv',
			'host'     => env('DB_HOST_SQLSERVER', 'localhost'),
			'database' => env('DB_DATABASE_SQLSERVER', 'forge'),
			'username' => env('DB_USERNAME_SQLSERVER', 'forge'),
			'password' => env('DB_PASSWORD_SQLSERVER', ''),
			'prefix'   => '',
		],

		'mongodb'   => [
			'driver'   => 'mongodb',
			'host'     => env('DB_HOST_MDB', 'localhost'),
			'database' => env('DB_DATABASE_MDB', 'forge'),
			'username' => env('DB_USERNAME_MDB', 'forge'),
			'password' => env('DB_PASSWORD_MDB', ''),
			'charset'  => 'utf8',
			'prefix'   => '',
		],

	],

	/*
	|--------------------------------------------------------------------------
	| Migration Repository Table
	|--------------------------------------------------------------------------
	|
	| This table keeps track of all the migrations that have already run for
	| your application. Using this information, we can determine which of
	| the migrations on disk haven't actually been run in the database.
	|
	 */

	'migrations' => 'migrations',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	 */

	'redis' => [

		'cluster' => false,

		'default'   => [
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		],

	],

];
