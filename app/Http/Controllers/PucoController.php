<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Datatables;
use DB;
use Storage;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\PUCO\Puco;
use App\Models\PUCO\ProcesoPuco as Proceso;
use App\Models\PUCO\Provincia;
use App\Models\Lote;

class PucoController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->middleware('auth');
	}

	/**
	 * Devuelve la vista principal para generar el PUCO
	 *
	 * @return null
	 */
	public function getGenerar(){
		$data = [
			'page_title' => 'Generar PUCO ' . date('M y'),
			'puco_ready' => $this->checkPuco()
		];
		return view('puco.generar' , $data);
	}

	/**
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function estadisticasTabla(){
		$datos = Puco::all();
		return Datatables::of($datos)->make(true);
	}

	/**
	 * Genera una contraseña aleatoria
	 *
	 * @return string
	 */
	protected function password ($length = 6) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&.?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}

	/** 
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function resumenTabla(){
		$datos = Provincia::leftJoin('sistema.subidas_osp' , 'sistema.subidas_osp.codigo_osp' , '=' , 'puco.obras_sociales_provinciales.codigo_osp')
						  ->leftJoin('sistema.subidas' , 'sistema.subidas_osp.id_subida' , '=' , 'sistema.subidas.id_subida')
						  ->leftJoin('sistema.lotes' , function ($j) {
					  	  		$j->on('sistema.subidas.id_subida' , '=' , 'sistema.lotes.id_subida')
					  	  		  ->where('sistema.lotes.id_estado' ,'=' , 3);
						  })
						  ->leftJoin('puco.procesos_obras_sociales' , function($j){
						  		$j->on('sistema.lotes.lote' , '=' , 'puco.procesos_obras_sociales.lote');
						  })->leftJoin('puco.obras_sociales' , 'puco.obras_sociales_provinciales.codigo_osp' , '=' , 'puco.obras_sociales.codigo_osp')
						  ->where('puco.procesos_obras_sociales.periodo' , '=' , date('Ym'))
						  ->get();
		return Datatables::of($datos)->make(true);
	}

	/**
	 * Devuelve el estado del PUCO
	 *
	 * @return int
	 */
	protected function checkPuco(){
		return Proceso::join('sistema.lotes' , 'puco.procesos_obras_sociales.lote' , '=' , 'sistema.lotes.lote')
					->where('periodo' , date('Ym'))
					->where('id_estado' , 3)
					->count();
	}

	/**
	 * Devuelve el nº de beneficiarios
	 * 
	 *
	 * @return int
	 */
	public function getBeneficiarios($periodo){
		$b = Proceso::join('sistema.lotes' , 'puco.procesos_obras_sociales.lote' , '=' , 'sistema.lotes.lote')
					->where('periodo' , $periodo)
					->where('id_estado' , 3)
					->select('registros_in')
					->sum('registros_in');
		return $b;
	}

	/**
	 * Guarda el resumen del PUCO
	 * @param string $pass
	 * @param int $beneficiarios
	 *
	 * @return bool
	 */
	protected function actualizarPuco($pass , $beneficiarios){
		$np = Puco::findOrNew(date('Ym'));
		$np->periodo = date('Ym');
		$np->clave = $pass;
		$np->registros = $beneficiarios;
		return $np->save();
	}

	/**
	 * Notifica por email
	 *
	 *
	 */
	protected function notificar($beneficiarios , $pass){
		Mail::send('emails.noti-puco', ['mes' => date('F') , 'beneficiarios' => $beneficiarios , 'pass' => $pass], function ($m) {
            $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
            $m->to('sistemasuec@gmail.com');
            $m->to('javier.minsky@gmail.com');
            $m->to('gustavo.hekel@gmail.com');
            $m->subject('PUCO ' . date('Ym'));
        });
	}

	/**
	 * Genera el PUCO
	 *
	 * @return string
	 */
	public function generar() {
		$password = $this->password();

		DB::statement("
			copy (
				select rpad (tipo_documento , 3 , ' ')	|| rpad (numero_documento :: text , 12 , ' ') || codigo_os || case when tipo_afiliado = 'T' then 'S' else 'N' end || rpad (nombre_apellido , 30 , ' ')  from puco.beneficiarios_osp union all
				select rpad (tipo_documento , 3 , ' ')	|| rpad (numero_documento :: text , 12 , ' ') || lpad (codigo_os :: text , 6 , '0') || case when codigo_parentesco :: int = 0 then 'S' else 'N' end || rpad (regexp_replace(nombre_apellido , '[^a-zA-Z] ' , '' , 'g') , 30 , ' ')  from puco.beneficiarios_sss union all
				select rpad (tipo_documento , 3 , ' ')	|| rpad (numero_documento :: text , 12 , ' ') || codigo_os || 'N' || rpad (nombre_apellido  , 30 , ' ') from puco.beneficiarios_profe
			) to '/var/www/html/sirge3/storage/swap/puco.txt' 
			");

		$puco = file_get_contents('/var/www/html/sirge3/storage/swap/puco.txt');
		$puco = str_replace("\n", "\r\n", $puco);
		
		file_put_contents('/var/www/html/sirge3/storage/swap/PUCO_' . date("Y-m") . '.txt', $puco);
		unset($puco);
		unlink('/var/www/html/sirge3/storage/swap/puco.txt');

		$sys = "cd /var/www/html/sirge3/storage/swap/; zip -P $password PUCO_" . date("Y-m") . ".zip PUCO_" . date('Y-m') . ".txt";
		// return $sys;
		exec($sys);

		$zh = fopen("/var/www/html/sirge3/storage/swap/PUCO_" . date("Y-m") . '.zip' , 'r');
		file_put_contents("/var/www/html/sirge3/storage/swap/PUCO_" . date("Y-m") . '.zip', $zh);
		
		$this->actualizarPuco($password , $this->getBeneficiarios(date('Ym')));
		$this->notificar($this->getBeneficiarios(date('Ym')) , $password);
		
		unlink('/var/www/html/sirge3/storage/swap/PUCO_' . date("Y-m") . '.txt');

		/*
		$puco = Storage::get('sirg3/puco/puco.txt');
		Storage::delete('sirg3/puco/puco.txt');
		
		$puco = str_replace("\n", "\r\n", $puco);
		file_put_contents('../storage/swap/puco.txt', $puco);
		
		$sys = "cd ../storage/swap/; zip -P $password PUCO_" . date("Y-m") . ".zip *";
		exec($sys);

		$zh = fopen("../storage/swap/PUCO_" . date("Y-m") . '.zip' , 'r');
		Storage::put("sirg3/puco/PUCO_" . date("Y-m") . ".zip" , $zh);
		$this->actualizarPuco($password , $this->getBeneficiarios(date('Ym')));
		$this->notificar($this->getBeneficiarios(date('Ym')) , $password);
		*/
	}

	/**
	 * Devuelve la vista de consultas
	 *
	 * @return null
	 */
	public function getConsulta(){
		$data = [
			'page_title' => 'Búsqueda de personas en PUCO'
		];
		return view('puco.consultas' , $data);
	}
}
