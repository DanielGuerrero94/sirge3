<?php

use Illuminate\Database\Seeder;

class ImportTableDepartamentosSchemaGeoSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//Model::unguard();

		$file = fopen(public_path() . '/imports/geo.departamentos_prueba.csv', 'r');
		feof($file);

		do {
			$fila = fgetcsv($file);
			if ($fila[0] == null && $fila[1] == null && $fila[2] == null && $fila[3] == null && $fila[4] == null) {
			} else {
				\DB::table('geo.departamentos')->insert(array(
					'id_provincia'        => $fila[0],
					'id_departamento'     => $fila[1],
					'nombre_departamento' => $fila[2],
				));
			}
		} while (!feof($file));
		fclose($file);
	}
}
