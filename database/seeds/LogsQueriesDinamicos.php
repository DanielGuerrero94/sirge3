<?php

use Illuminate\Database\Seeder;

class LogsQueriesDinamicos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO logs.queries_dinamicos(id_query_dinamico,id_usuario,consulta,consulta_ok,descarga,timestamp)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_consulta,id_usuario,consulta,consulta_ok,descarga,timestamp
			FROM
				sistema.log_queries_din;')
		    AS migracion(id_query_dinamico integer,
				id_usuario integer,
				consulta text,
				consulta_ok char(1),
				descarga char(1),
				timestamp TIMESTAMP	
				)
	); ");
    }
}
