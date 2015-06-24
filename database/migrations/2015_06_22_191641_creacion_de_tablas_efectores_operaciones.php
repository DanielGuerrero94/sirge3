<?php

use Illuminate\Database\Migrations\Migration;

class CreacionDeTablasEfectoresOperaciones extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement("CREATE TABLE efectores.operaciones
                    (
                      id_efector integer NOT NULL,
                      id_usuario_operacion integer,
                      fecha_operacion timestamp without time zone NOT NULL DEFAULT ('now'::text)::timestamp without time zone,
                      tipo_operacion integer,
                      observaciones text,
                      CONSTRAINT operaciones_pkey PRIMARY KEY (id_efector, fecha_operacion),
                      CONSTRAINT fkey_id_efector_operaciones FOREIGN KEY (id_efector)
                          REFERENCES efectores.efectores (id_efector) MATCH SIMPLE
                          ON UPDATE NO ACTION ON DELETE CASCADE
                    )");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.operaciones');
	}
}
