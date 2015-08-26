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
		$this->call('GeoGeojson');
		$this->call('GeoGepDepartamentos');
		$this->call('GeoLocalidades');
		$this->call('GeoUbicacionProvincias');
		$this->call('EfectoresCategoriasPpac');
		$this->call('EfectoresNeonatales');
		$this->call('EfectoresObstetricos');
		$this->call('EfectoresEfectoresPpac');
		$this->call('EfectoresTipoCategorizacion');
		$this->call('EfectoresTipoDependenciaAdministrativa');
		$this->call('EfectoresTipoEfecotr');
		$this->call('EfectoresTipoEstado');
		$this->call('EfectoresTipoTelefono');
		$this->call('EfectoresEfectores');
		$this->call('EfectoresCompromisoGestion');
		$this->call('EfectoresConvenioAdministrativo');
		$this->call('EfectoresDatosGeograficos');
		$this->call('EfectoresDescentralizacion');
		$this->call('EfectoresEmail');
		$this->call('EfectoresOperaciones');
		$this->call('EfectoresReferentes');
		$this->call('EfectoresTelefonos');
		$this->call('SistemaEstados');
		$this->call('SistemaPadrones');
		$this->call('SistemaRegiones');
		$this->call('SistemaParametros');
		$this->call('SistemaModulos');
		$this->call('SistemaModulosMenu');
		$this->call('SistemaComentarios');
		$this->call('SistemaSugerencias');
		$this->call('SistemaLotes');
		$this->call('SistemaLotesAceptados');
		$this->call('SistemaLotesRechazados');

		Model::reguard();
	}
}
