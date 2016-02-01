<?php

use Illuminate\Database\Seeder;

class IndicadoresIndicadoresMedica extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indicadores.indicadores_medica(id_provincia,periodo,codigo_indicador,resultado)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.37 user=postgres password=BernardoCafe008',
		    'SELECT id_provincia,periodo,codigo_indicador,coalesce(resultado,0)		    
			FROM
				indicadores.indicadores_medica i WHERE periodo = 201512')
		    AS migracion(id_provincia char(2),
				periodo integer,
				codigo_indicador character varying(6),
				resultado integer				
				)
	); ");

        \DB::statement(" UPDATE indicadores.indicadores_medica SET id_rango_indicador = r.valor 
						FROM
							(SELECT mr.codigo_indicador as codigo_indicadormr,mr.id_rango_indicador as valor, substring(mr.periodo::text,1,4) as periodomr, mr.id_provincia as id_provinciamr
								FROM indicadores.indicadores_medica_rangos mr 		
							) as r

							WHERE id_provincia = r.id_provinciamr 
							AND r.periodomr = substring(periodo::text,1,4) 
							AND left(codigo_indicador,-2) =  r.codigo_indicadormr ");
    }
}
