<?php

use Illuminate\Database\Seeder;

class IndicadoresIndicadoresPriorizados extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indicadores.indicadores_priorizados(efector,periodo,numerador,id_provincia,indicador,denominador)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT efector,periodo,numerador,id_provincia,indicador,denominador
			FROM
				indicadores.indicadores_priorizados;')
		    AS migracion(efector character varying (8),
				periodo integer,
				numerador integer,
				id_provincia char(2),
				indicador character varying(5),
				denominador integer				
				)
	); ");

        \DB::statement(" CREATE OR REPLACE FUNCTION indicadores.resumen_anio_indicadores_priorizados(
    IN var_periodo integer,
    IN var_provincia character varying,
    IN var_indicador character varying,
    OUT nombre character varying,
    OUT efector character varying,
    OUT enero bigint,
    OUT febrero bigint,
    OUT marzo bigint,
    OUT abril bigint,
    OUT mayo bigint,
    OUT junio bigint,
    OUT julio bigint,
    OUT agosto bigint,
    OUT septiembre bigint,
    OUT octubre bigint,
    OUT noviembre bigint,
    OUT diciembre bigint)
  RETURNS SETOF record AS
$BODY$
BEGIN
RETURN QUERY select i.nombre, i.efector, sum(case periodo
		when $1 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 1 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end) 
		, sum(case periodo
		when $1 + 2 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 3 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 4 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 5 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 6 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 7 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 8 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 9 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 10 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 11 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
	FROM 
		indicadores.indicadores_priorizados i
	WHERE 
		id_provincia = var_provincia
	AND 
		indicador = var_indicador 
	GROUP BY 1,2;
END
$BODY$
  LANGUAGE plpgsql STABLE STRICT
  COST 100
  ROWS 1000; ");

	\DB::statement(" CREATE OR REPLACE FUNCTION indicadores.resumen_anio_indicadores_priorizados_efector(
    IN var_periodo integer,
    IN var_efector character varying,
    IN var_indicador character varying,
    OUT nombre character varying,
    OUT efector character varying,
    OUT enero bigint,
    OUT febrero bigint,
    OUT marzo bigint,
    OUT abril bigint,
    OUT mayo bigint,
    OUT junio bigint,
    OUT julio bigint,
    OUT agosto bigint,
    OUT septiembre bigint,
    OUT octubre bigint,
    OUT noviembre bigint,
    OUT diciembre bigint)
  RETURNS SETOF record AS
$BODY$
BEGIN
RETURN QUERY select i.nombre, i.efector, sum(case periodo
		when $1 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 1 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end) 
		, sum(case periodo
		when $1 + 2 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 3 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 4 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 5 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 6 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 7 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 8 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 9 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 10 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 11 then ( case denominador
				   when 0 then 0
				   else numerador*100 / denominador end
				)
		else 0 end)
	FROM 
		indicadores.indicadores_priorizados i
	WHERE 
		i.efector = var_efector
	AND 
		indicador = var_indicador 
	GROUP BY 1,2;
END
$BODY$
  LANGUAGE plpgsql STABLE STRICT
  COST 100
  ROWS 1000; ");

	\DB::statement(" CREATE OR REPLACE FUNCTION indicadores.resumen_anio_indicadores_priorizados_efector_no_porcentual(
    IN var_periodo integer,
    IN var_efector character varying,
    IN var_indicador character varying,
    OUT nombre character varying,
    OUT efector character varying,
    OUT enero bigint,
    OUT febrero bigint,
    OUT marzo bigint,
    OUT abril bigint,
    OUT mayo bigint,
    OUT junio bigint,
    OUT julio bigint,
    OUT agosto bigint,
    OUT septiembre bigint,
    OUT octubre bigint,
    OUT noviembre bigint,
    OUT diciembre bigint)
  RETURNS SETOF record AS
$BODY$
BEGIN
RETURN QUERY select i.nombre, i.efector, sum(case periodo
		when $1 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 1 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end) 
		, sum(case periodo
		when $1 + 2 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 3 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 4 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 5 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 6 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 7 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 8 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 9 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 10 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 11 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
	FROM 
		indicadores.indicadores_priorizados i
	WHERE 
		i.efector = var_efector
	AND 
		indicador = var_indicador 
	GROUP BY 1,2;
END
$BODY$
  LANGUAGE plpgsql STABLE STRICT
  COST 100
  ROWS 1000; ");

	\DB::statement(" CREATE OR REPLACE FUNCTION indicadores.resumen_anio_indicadores_priorizados_no_porcentual(
    IN var_periodo integer,
    IN var_provincia character varying,
    IN var_indicador character varying,
    OUT nombre character varying,
    OUT efector character varying,
    OUT enero bigint,
    OUT febrero bigint,
    OUT marzo bigint,
    OUT abril bigint,
    OUT mayo bigint,
    OUT junio bigint,
    OUT julio bigint,
    OUT agosto bigint,
    OUT septiembre bigint,
    OUT octubre bigint,
    OUT noviembre bigint,
    OUT diciembre bigint)
  RETURNS SETOF record AS
$BODY$
BEGIN
RETURN QUERY select i.nombre, i.efector, sum(case periodo
		when $1 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 1 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end) 
		, sum(case periodo
		when $1 + 2 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 3 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 4 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 5 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 6 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 7 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 8 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 9 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 10 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
		, sum(case periodo
		when $1 + 11 then ( case denominador
				   when 0 then 0
				   else denominador end
				)
		else 0 end)
	FROM 
		indicadores.indicadores_priorizados i
	WHERE 
		id_provincia = var_provincia
	AND 
		indicador = var_indicador 
	GROUP BY 1,2;
END
$BODY$
  LANGUAGE plpgsql STABLE STRICT
  COST 100
  ROWS 1000; ");
    }
}
