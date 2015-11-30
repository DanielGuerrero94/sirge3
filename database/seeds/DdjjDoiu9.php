<?php

use Illuminate\Database\Seeder;

class DdjjDoiu9 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO ddjj.doiu9(id_impresion,id_provincia,id_usuario,periodo_reportado,efectores_integrantes,efectores_convenio,periodo_tablero_control,fecha_cuenta_capitas,periodo_cuenta_capitas,fecha_sirge,periodo_sirge,fecha_reporte_bimestral,bimestre,anio_bimestre,version,motivo_reimpresion,fecha_impresion)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_impresion,id_provincia, id_usuario, periodo_reportado, efectores_integrantes, efectores_convenio, periodo_tablero_control, fecha_cuenta_capitas, periodo_cuenta_capitas, fecha_sirge, periodo_sirge, fecha_reporte_bimestral, bimestre, anio_bimestre, version, motivo_reimpresion, fecha_impresion   
		    FROM sistema.impresiones_ddjj_doiu')
		    AS migracion(id_impresion integer,
				  id_provincia character(2),
				  id_usuario integer,
				  periodo_reportado character(7),
				  efectores_integrantes integer,
				  efectores_convenio integer,
				  periodo_tablero_control character(7),
				  fecha_cuenta_capitas date,
				  periodo_cuenta_capitas character(7),
				  fecha_sirge date,
				  periodo_sirge character(7),
				  fecha_reporte_bimestral date,
				  bimestre smallint,
				  anio_bimestre integer,
				  version integer,
				  motivo_reimpresion text,
				  fecha_impresion timestamp without time zone)
	); ");
    }
}
