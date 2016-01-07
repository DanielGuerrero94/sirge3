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

		/*$this->call('SistemaProvinciasSeeder');
		$this->call('SistemaAreasSeeder');
		$this->call('PssDiagnosticosSeeder');
		$this->call('PssCodigosSeeder');
		$this->call('SistemaClasesDocumento');
		$this->call('PssGruposEtarios');
		$this->call('SistemaSexos');
		$this->call('SistemaTipoDocumento');
		$this->call('BeneficiariosBeneficiarios');
		$this->call('SistemaMenues');
		//$this->call('SistemaTipoEntidad');
		$this->call('SistemaEntidades');		
		$this->call('SistemaUsuarios');
		$this->call('GeoDepartamentos');
		$this->call('GeoEntidades');
		$this->call('GeoGeojson');
		$this->call('GeoGepDepartamentos');
		$this->call('GeoLocalidades');		
		$this->call('EfectoresCategoriasPpac');
		$this->call('EfectoresNeonatales');
		$this->call('EfectoresObstetricos');		
		$this->call('EfectoresTipoCategorizacion');
		$this->call('EfectoresTipoDependenciaAdministrativa');
		$this->call('EfectoresTipoEfecotr');
		$this->call('EfectoresTipoEstado');
		$this->call('EfectoresTipoTelefono');
		$this->call('EfectoresEfectores');
		$this->call('EfectoresEfectoresPpac');
		$this->call('EfectoresCompromisoGestion');
		$this->call('EfectoresConvenioAdministrativo');
		$this->call('EfectoresDatosGeograficos');
		$this->call('EfectoresDescentralizacion');
		$this->call('EfectoresEmail');		
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
		$this->call('SistemaSubidas');
		$this->call('SistemaLotes');
		$this->call('SistemaLotesAceptados');
		$this->call('SistemaLotesRechazados');
		$this->call('PssLineasCuidado');
		$this->call('PssModulosCCC');
		$this->call('PssTipoPrestacion');			
		$this->call('PssCodigosAnexo');
		$this->call('PssCodigosCatastroficos');
		$this->call('PssCodigosCCC');
		$this->call('PssCodigosCeb');
		$this->call('PssCodigosEstrategicos');
		$this->call('PssCodigosGrupos');
		$this->call('PssCodigosOdp');
		$this->call('PssCodigosPpac');
		$this->call('PssCodigosPriorizadas');
		$this->call('PssCodigosSumarNacer');
		$this->call('TrazadorasTrazadoras');
		$this->call('PssCodigosTrazadoras');
		$this->call('PssGruposDiagnosticos');*/
		// $this->call('BeneficiariosBeneficiariosBajas');
		// $this->call('BeneficiariosBeneficiariosCategoriasNacer');
		// $this->call('BeneficiariosBeneficiariosCeb');
		// $this->call('BeneficiariosBeneficiariosContacto');
		// $this->call('BeneficiariosBeneficiariosEmbarazos');
		$this->call('BeneficiariosBeneficiariosGeografico');
		// $this->call('BeneficiariosBeneficiariosIndigenas');
		// $this->call('BeneficiariosBeneficiariosParientes');
		// $this->call('BeneficiariosBeneficiariosPeriodos');		
		//$this->call('BeneficiariosBeneficiariosScore');
		$this->call('BeneficiariosResumenBeneficiarios');
		/*$this->call('PrestacionesP');
		$this->call('ComprobantesC');
		$this->call('FondosCodigosGasto');
		$this->call('FondosSubCodigosGasto');
		$this->call('FondosA');
		$this->call('PucoObrasSociales');
		$this->call('PucoObrasSocialesProvinciales');
		$this->call('CompromisoAnualMetasCodigosValidos');
		$this->call('CompromisoAnualMetasDescentralizacion');
		$this->call('CompromisoAnualMetasFacturacion');
		$this->call('DdjjBackup');
		$this->call('DdjjDoiu9');
		$this->call('DdjjSirge');
		//$this->call('IndecPoblacion');
		//$this->call('IndecPoblacionDepartamentos');
		$this->call('IndicadoresIndicadoresDescripcion');
		$this->call('IndicadoresIndicadoresMedica');
		$this->call('IndicadoresIndicadoresMedicaRangos');
		$this->call('IndicadoresIndicadoresPriorizados');
		$this->call('IndicadoresMetasEfectoresPriorizados');
		$this->call('IndicadoresProvincias');
		$this->call('LogsLogins');
		$this->call('LogsQueriesDinamicos');
		$this->call('EfectoresAddendas');
		$this->call('EfectoresEfectoresAddendas');
		//$this->call('OspProvincias');*/

		Model::reguard();
	}
}
