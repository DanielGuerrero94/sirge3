<?php

use Illuminate\Database\Seeder;

class SistemaSubidas extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		/*\DB::statement("INSERT INTO sistema.subidas(id_subida,id_usuario,fecha_subida,id_padron,nombre_original,nombre_actual,size,id_estado)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_carga,id_usuario_carga,fecha_carga,id_padron,nombre_original,nombre_actual,size,case procesado
														when ''N'' then 0
														when ''S'' then 1
														when ''P'' then 2
														when ''E'' then 3
														else 4 end
			    FROM sistema.cargas_archivos l')
		    AS migracion(id_subida integer,
				 id_usuario integer,
				 fecha_subida timestamp(0) without time zone,
				 id_padron integer,
				 nombre_original text,
				 nombre_actual text,
				 size double precision,
				 id_estado integer)
	);");*/

	/*	\DB::statement("INSERT INTO sistema.subidas_aceptadas(id_subida,id_usuario,fecha_aceptado)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_carga,id_usuario_carga,coalesce(fecha_proceso,''2012-01-01 00:00:00.00000'')
			    FROM sistema.cargas_archivos l WHERE procesado = ''S'' ')
		    AS migracion(id_subida integer,
				 id_usuario integer,
				 fecha_aceptado timestamp(0) without time zone
				 )
	);");

		\DB::statement("INSERT INTO sistema.subidas_eliminadas(id_subida,id_usuario,fecha_eliminado)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_carga,id_usuario_carga,coalesce(fecha_baja,''2012-01-01 00:00:00.00000'')
			    FROM sistema.cargas_archivos l WHERE procesado = ''E'' ')
		    AS migracion(id_subida integer,
				 id_usuario integer,
				 fecha_eliminado timestamp(0) without time zone
				 )
	);");
	*/

		\DB::statement("INSERT INTO sistema.subidas_osp(id_subida,codigo_osp,id_archivo,nombre_backup)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT o.id_carga,codigo_os,id_archivo_sss,nombre_backup
	 			FROM sistema.cargas_archivos l
	 			INNER JOIN sistema.cargas_archivos_osp o on o.id_carga = l.id_carga AND id_padron = 6 ')
		    AS migracion(id_subida integer,
				 codigo_osp integer,
				 id_archivo smallint,
				 nombre_backup character varying(100)
				 )
	);");
	}
}
