<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard();

		// $this->call('UserTableSeeder');
		//$this->call('ImportTableDepartamentosSchemaGeoSeeder');
		//$this->call('ImportTableEntidadesSchemaGeoSeeder');
		$this->call('SistemaProvinciasSeeder');
		$this->call('SistemaAreasSeeder');
		$this->call('PssDiagnosticosSeeder');
		$this->call('PssCodigosSeeder');
		$this->call('SistemaClasesDocumento');
		$this->call('PssGruposEtarios');
		$this->call('SistemaSexos');
		$this->call('SistemaTipoDocumento');
		$this->call('BeneficiariosBeneficiarios');
		$this->call('SistemaMenues');
		$this->call('SistemaUsuarios');
		$this->call('GeoDepartamentos');
		$this->call('GeoEntidades');

		Model::reguard();
	}
}
