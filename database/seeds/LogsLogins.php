<?php

use Illuminate\Database\Seeder;

class LogsLogins extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO logs.logins(id_inicio,id_usuario,fecha_login,ip)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_inicio,id_usuario,fecha_login,ip
			FROM
				sistema.log_logins;')
		    AS migracion(id_inicio integer,
				id_usuario integer,
				fecha_login timestamp,
				ip cidr			
				)
	); ");
    }
}
