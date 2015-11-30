<?php

use Illuminate\Database\Seeder;

class DdjjBackup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO ddjj.backup(id_impresion,id_provincia,id_usuario,periodo_reportado,fecha_backup,nombre_backup,version,motivo_reimpresion,fecha_impresion)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_impresion,id_provincia, id_usuario, periodo_reportado, fecha_backup, nombre_backup, version, motivo_reimpresion, fecha_impresion 
			    FROM sistema.impresiones_ddjj_backup')
		    AS migracion(id_impresion integer,
				  id_provincia character(2),
				  id_usuario integer,
				  periodo_reportado character(7),
				  fecha_backup date,
				  nombre_backup text,
				  version integer,
				  motivo_reimpresion text,
				  fecha_impresion timestamp without time zone)
	); ");
    }
}
