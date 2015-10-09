<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PadronesController extends Controller
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
	 * Devuelve la vista principal
	 * @param string $padron
	 * @param int $id
	 * 
	 * @return null
	 */
	public function getMain($padron , $id){
		$data = [
			'page_title' => ucwords($padron),
			'id_padron' => $id
		];
		return view('padrones.main' , $data);
	}

	/**
	 * Devuelve la ruta donde guardar el archivo
	 * @param int $id
	 *
	 * @return string
	 */
	protected function getRoute($id){
		switch ($id) {
			case 1:
				$p = 'prestaciones'; break;
			case 2 :
				$p = 'fondos'; break;
			case 3 :
				$p = 'comprobantes'; break;
			case 4 : 
				$p = 'osp'; break;
			case 5 :
				$p = 'profe'; break;
			case 6 :
				$p = 'sss'; break;
			default:
				break;
		}
		return '/storage/uploads/' . $p;
	}

	/** 
	 * Devuelve la vista para subir un padrón
	 * @param int $id
	 *
	 * @return null
	 */
	public function getUpload($id){
		$data = [
			'page_title' => 'Subir archivos'
		];
		return view('padrones.upload-files' , $data);
	}

	/**
	 * Guarda el archivo en el sistema
	 * @param $r Request
	 *
	 * @return json
	 */
	public function postUpload(Request $r){


		/**
			- CREAR UN UNIQUEID PARA RENOMBRAR EL ARCHIVO
			- GUARDAR EL REGISTRO EN LA BDD
			- MOVER EL ARCHIVO A LA RUTA /storage/uploads/{getUpload}
			- DEVOLVER UN JSON CON EL NOMBRE ORIGINAL DEL ARCHIVO SUBIDO
		*/

		print_r($r->file());
		echo 'id padron : ' . print_r($r->id_padron);
		//$r->file('file')->move($destino , $nombre);

	}
}
