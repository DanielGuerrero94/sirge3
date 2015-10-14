<?php

namespace App\Http\Controllers;

use ErrorException;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;

class PrestacionesController extends Controller
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
	 * Procesa el archivo de prestaciones
	 * @param int $id
	 *
	 * @return json
	 */
	public function procesarArchivo($id){
		
		$info = Subida::findOrFail($id);

		try {
			$fh = fopen ('../storage/uploads/prestaciones/' . $info->nombre_actual , 'r');
			
			$data = [
				'estado' => 'F'
			];

			$this->validate($data , [
				'estado' => 'in:A,B,C'
			]);
			
			return 'ok';
		} catch (ErrorException $e){
			return $e;
			//return response('No se pudo abrir el archivo' , 422);
		}
	}



}
