<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCodigoPrestacionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	//UPDATE a las tablas de datawarehouse
	$tables = DB::connection('datawarehouse')->select("SELECT concat(table_schema,'.',table_name) as name FROM information_schema.columns WHERE (column_name = 'codigo_prestacion') and table_schema not in ('indec', 'envioDN', 'temporales');");

	foreach($tables as $table) {
	    $statement = <<<HEREDOC
	    ALTER TABLE $table->name 
	    ALTER COLUMN codigo_prestacion TYPE character varying(21);
HEREDOC;
	    DB::connection('datawarehouse')->statement($statement);
        }

	//UPDATE a las tablas de sirge 3 salvo las que estan relacionadas con views o materialized views
	$tables = DB::connection('pgsql')->select("SELECT concat(table_schema,'.',table_name) as name FROM information_schema.columns WHERE (column_name = 'codigo_prestacion') and table_schema not in ('indec', 'envioDN', 'temporales') and table_name not in ('mv_beneficiarios_ceb', 'beneficiarios_ceb', 'ceb', 'prestaciones', 'prestaciones_completo');");

	foreach($tables as $table) {
	    $statement = <<<HEREDOC
	    ALTER TABLE $table->name 
	    ALTER COLUMN codigo_prestacion TYPE character varying(21);
HEREDOC;
	    DB::connection('pgsql')->statement($statement);
        }

	$statements = [];
	//UPDATE beneficiarios.ceb tirando y levantando una mv
	$statements[] = <<<HEREDOC
	    DROP MATERIALIZED VIEW IF EXISTS beneficiarios.mv_beneficiarios_ceb;
HEREDOC;

	$statements[] = <<<HEREDOC
	    DROP VIEW IF EXISTS beneficiarios.beneficiarios_ceb;
HEREDOC;

	$statements[] = <<<HEREDOC
            ALTER TABLE beneficiarios.ceb
            ALTER COLUMN codigo_prestacion TYPE character varying(21);
HEREDOC;

	//UPDATE prestaciones.prestaciones tirando y levantando una view
	$statements[] = <<<HEREDOC
	    DROP VIEW IF EXISTS prestaciones.prestaciones_completo CASCADE;
HEREDOC;

	$statements[] = <<<HEREDOC
            ALTER TABLE prestaciones.prestaciones
            ALTER COLUMN codigo_prestacion TYPE character varying(21);
HEREDOC;

	$statements[] = <<<HEREDOC
 	    CREATE VIEW prestaciones.prestaciones_completo as (
		SELECT dg.id_provincia,
		    p.id,
		    p.estado,
		    p.efector,
		    p.numero_comprobante,
		    p.codigo_prestacion,
		    p.subcodigo_prestacion,
		    p.precio_unitario,
		    p.fecha_prestacion,
		    p.clave_beneficiario,
		    p.tipo_documento,
		    p.clase_documento,
		    p.numero_documento,
		    p.orden,
		    p.lote,
		    p.datos_reportables
		FROM prestaciones.prestaciones p
		JOIN efectores.efectores e ON e.cuie = p.efector
		JOIN efectores.datos_geograficos dg ON e.id_efector = dg.id_efector
		JOIN sistema.lotes l ON p.lote = l.lote
	        WHERE p.estado = 'L'::bpchar AND l.id_estado = 3);
HEREDOC;

	$statements[] = <<<HEREDOC
	    CREATE MATERIALIZED VIEW beneficiarios.mv_beneficiarios_ceb as (
		 SELECT benef_ceb.clave_beneficiario,
		    benef_ceb.ceb,
		    benef_ceb.efector,
		    benef_ceb.fecha_ultima_prestacion,
		    benef_ceb.codigo_prestacion
		 FROM beneficiarios.ceb benef_ceb
	         WHERE benef_ceb.periodo = (( SELECT max(m.periodo) AS max
                 FROM scheduler.migracion_beneficiarios m)));
HEREDOC;

	$statements[] = <<<HEREDOC
	    CREATE VIEW beneficiarios.beneficiarios_ceb as (
		 SELECT b.clave_beneficiario,
		    b.apellido,
		    b.nombre,
		    b.tipo_documento,
		    b.clase_documento,
		    b.numero_documento,
		    b.sexo,
		    b.pais,
		    b.fecha_nacimiento,
		    b.fecha_inscripcion,
		    b.fecha_alta_efectiva,
		    b.id_provincia_alta,
		    b.discapacidad,
		    b.observaciones,
		    b.grupo_actual,
		    b.grupo_alta,
		    p.codigo_prestacion,
		    p.fecha_ultima_prestacion,
		    p.efector
	         FROM beneficiarios.beneficiarios b
		 JOIN beneficiarios.ceb p ON b.clave_beneficiario::text = p.clave_beneficiario::text AND p.periodo = (( SELECT max(migracion_beneficiarios.periodo) AS max
	         FROM scheduler.migracion_beneficiarios))
	         WHERE p.ceb = 'S'::bpchar);
HEREDOC;


	foreach($statements as $statement) {
	    DB::connection('pgsql')->statement($statement);
	}

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	$tables = DB::connection('datawarehouse')->select("SELECT concat(table_schema,'.',table_name) as name FROM information_schema.columns WHERE (column_name = 'codigo_prestacion') and table_schema not in ('indec', 'envioDN', 'temporales') and table_name not in ('mv_beneficiarios_ceb', 'beneficiarios_ceb');");

	foreach($tables as $table) {
	    $statement = <<<HEREDOC
	    ALTER TABLE $table->name 
	    ALTER COLUMN codigo_prestacion TYPE character varying(11);
HEREDOC;
	    DB::connection('datawarehouse')->statement($statement);
        }

	$tables = DB::connection('pgsql')->select("SELECT concat(table_schema,'.',table_name) as name FROM information_schema.columns WHERE (column_name = 'codigo_prestacion') and table_schema not in ('indec', 'envioDN', 'temporales');");

	foreach($tables as $table) {
	    $statement = <<<HEREDOC
	    ALTER TABLE $table->name 
	    ALTER COLUMN codigo_prestacion TYPE character varying(11);
HEREDOC;
	    DB::connection('pgsql')->statement($statement);
        }

	$statements = [];
	//UPDATE beneficiarios.ceb tirando y levantando una mv
	$statements[] = <<<HEREDOC
	    DROP MATERIALIZED VIEW IF EXISTS beneficiarios.mv_beneficiarios_ceb;
HEREDOC;

	$statements[] = <<<HEREDOC
	    DROP VIEW IF EXISTS beneficiarios.beneficiarios_ceb;
HEREDOC;

	$statements[] = <<<HEREDOC
            ALTER TABLE beneficiarios.ceb
            ALTER COLUMN codigo_prestacion TYPE character varying(11);
HEREDOC;

	$statements[] = <<<HEREDOC
	    CREATE MATERIALIZED VIEW beneficiarios.mv_beneficiarios_ceb as (
		 SELECT benef_ceb.clave_beneficiario,
		    benef_ceb.ceb,
		    benef_ceb.efector,
		    benef_ceb.fecha_ultima_prestacion,
		    benef_ceb.codigo_prestacion
		 FROM beneficiarios.ceb benef_ceb
	         WHERE benef_ceb.periodo = (( SELECT max(m.periodo) AS max
                 FROM scheduler.migracion_beneficiarios m)));
HEREDOC;

	$statements[] = <<<HEREDOC
	    CREATE VIEW beneficiarios.beneficiarios_ceb as (
		 SELECT b.clave_beneficiario,
		    b.apellido,
		    b.nombre,
		    b.tipo_documento,
		    b.clase_documento,
		    b.numero_documento,
		    b.sexo,
		    b.pais,
		    b.fecha_nacimiento,
		    b.fecha_inscripcion,
		    b.fecha_alta_efectiva,
		    b.id_provincia_alta,
		    b.discapacidad,
		    b.observaciones,
		    b.grupo_actual,
		    b.grupo_alta,
		    p.codigo_prestacion,
		    p.fecha_ultima_prestacion,
		    p.efector
	         FROM beneficiarios.beneficiarios b
		 JOIN beneficiarios.ceb p ON b.clave_beneficiario::text = p.clave_beneficiario::text AND p.periodo = (( SELECT max(migracion_beneficiarios.periodo) AS max
	         FROM scheduler.migracion_beneficiarios))
	         WHERE p.ceb = 'S'::bpchar);
HEREDOC;

	//UPDATE prestaciones.prestaciones tirando y levantando una view
	$statements[] = <<<HEREDOC
	    DROP VIEW IF EXISTS prestaciones.prestaciones_completo CASCADE;
HEREDOC;

	$statements[] = <<<HEREDOC
            ALTER TABLE prestaciones.prestaciones
            ALTER COLUMN codigo_prestacion TYPE character varying(11);
HEREDOC;

	$statements[] = <<<HEREDOC
 	    CREATE VIEW prestaciones.prestaciones_completo as (
		SELECT dg.id_provincia,
		    p.id,
		    p.estado,
		    p.efector,
		    p.numero_comprobante,
		    p.codigo_prestacion,
		    p.subcodigo_prestacion,
		    p.precio_unitario,
		    p.fecha_prestacion,
		    p.clave_beneficiario,
		    p.tipo_documento,
		    p.clase_documento,
		    p.numero_documento,
		    p.orden,
		    p.lote,
		    p.datos_reportables
		FROM prestaciones.prestaciones p
		JOIN efectores.efectores e ON e.cuie = p.efector
		JOIN efectores.datos_geograficos dg ON e.id_efector = dg.id_efector
		JOIN sistema.lotes l ON p.lote = l.lote
	        WHERE p.estado = 'L'::bpchar AND l.id_estado = 3);
HEREDOC;

	foreach($statements as $statement) {
	    DB::connection('pgsql')->statement($statement);
	}


    }
}
