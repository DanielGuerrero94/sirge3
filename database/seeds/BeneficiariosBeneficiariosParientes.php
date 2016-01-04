<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosParientes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.parientes(clave_beneficiario,madre_tipo_documento,madre_numero_documento,madre_apellido,madre_nombre,padre_tipo_documento,padre_numero_documento,padre_apellido,padre_nombre,otro_tipo_documento,otro_numero_documento,otro_apellido,otro_nombre,otro_tipo_relacion)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,madre_tipo_documento,madre_numero_documento,madre_apellido,madre_nombre,padre_tipo_documento,padre_numero_documento,padre_apellido,padre_nombre,otro_tipo_documento,otro_numero_documento,otro_apellido,otro_nombre,otro_tipo_relacion
			    FROM beneficiarios.beneficiarios_parientes')
		    AS migracion(clave_beneficiario character varying(16),
				  madre_tipo_documento character varying(5),
				  madre_numero_documento character varying(14),
				  madre_apellido character varying(100),
				  madre_nombre character varying(100),
				  padre_tipo_documento character varying(5),
				  padre_numero_documento character varying(14),
				  padre_apellido character varying(100),
				  padre_nombre character varying(100),
				  otro_tipo_documento character varying(13),
				  otro_numero_documento character varying(14),
				  otro_apellido character varying(100),
				  otro_nombre character varying(100),
				  otro_tipo_relacion smallint)			
	); ");
    }
}
