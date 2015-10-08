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
}
