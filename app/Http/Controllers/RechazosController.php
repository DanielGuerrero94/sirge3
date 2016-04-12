<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lote;
use App\Models\Rechazo;
use App\Models\AccesoWS;

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
		
		$acc = new AccesoWS;
		$acc->ws = 1;
		$acc->save();

		$rechazos = Rechazo::select('lote' , 'registro' , 'motivos' , 'created_at')->where('lote' , $lote)->get();

		if (! count($rechazos)){
			return response()->json(['mensaje' => 'El lote seleccionado fue eliminado o no posee rechazos']);
		}

		foreach ($rechazos as $key => $rechazo){
			$rechazos[$key]['registro'] = json_decode($rechazo['registro']);
			$rechazos[$key]['motivos'] = json_decode($rechazo['motivos']);
		}

		return response()->json($rechazos);
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
		curl_setopt($ch, CURLOPT_URL, "http://localhost/sirge3/public/rechazos/$lote");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

		// Capturar la URL y pasarla a una variable
		$rechazos = json_decode(curl_exec($ch) , true);

		// Cerrar el recurso cURL y liberar recursos del sistema
		curl_close($ch);

		return response()->json($rechazos);
		
	}
}
