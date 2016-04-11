<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lote;
use App\Models\Rechazo;

class RechazosController extends Controller
{
    /**
	 * Create a new authentication controller instance.
	 *
	 * @return void
 	 */
	public function __construct(){
		// $this->middleware('auth');
	}

	/**
	 * Devuelve un csv con los rechazos
	 * @param int $lote
	 *
	 * @return json
	 */
	public function descargarRechazos($lote){
		return response()->json(Rechazo::where('lote' , $lote)->get());
	}

	/**
	 * Testeo web service rechazo
	 * @param int $lote
	 *
	 * @return string
	 */
	public function curlRechazo($lote){
		// Crear un nuevo recurso cURL
		$ch = curl_init();

		// Establecer URL y otras opciones apropiadas
		curl_setopt($ch, CURLOPT_URL, "http://localhost/sirge3/public/rechazos-lote-descargar/5300");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

		// Capturar la URL y pasarla al navegador
		$rechazos = json_decode(curl_exec($ch));

		// Cerrar el recurso cURL y liberar recursos del sistema
		curl_close($ch);

		foreach ($rechazos as $rechazo){
			echo '<pre>' , json_encode($rechazo , JSON_PRETTY_PRINT) . '</pre><br/>';
		}
	}
}
