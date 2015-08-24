<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiarios extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO beneficiarios.beneficiarios(clave_beneficiario,apellido,nombre,tipo_documento,clase_documento,numero_documento,sexo,pais,fecha_nacimiento,fecha_inscripcion,fecha_alta_efectiva,id_provincia_alta,discapacidad,observaciones,grupo_actual,grupo_alta)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT clave_beneficiario,apellido,nombre,tipo_documento,clase_documento,numero_documento,sexo,pais,fecha_nacimiento,fecha_inscripcion,fecha_alta_efectiva,id_provincia_alta,discapacidad,observaciones,grupo_actual,grupo_alta
			    FROM beneficiarios.beneficiarios')
		    AS sirge_beneficiarios_beneficiarios(clave_beneficiario character varying(16),apellido character varying(100),nombre character varying(100),tipo_documento char(3),clase_documento char(1),numero_documento character varying(14), sexo char(1), pais character varying(100),fecha_nacimiento date,fecha_inscripcion date,fecha_alta_efectiva date,id_provincia_alta char(2),discapacidad char(1),observaciones character varying(200),grupo_actual smallint,grupo_alta char(1))
	 )
        			   	");
	}
}
