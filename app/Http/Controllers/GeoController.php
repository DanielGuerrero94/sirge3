<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Geo\Departamento;
use App\Models\Geo\Localidad;

class GeoController extends Controller
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
     * Devuelvo los departamentos de una provincia determinada
     * @param char $provincia
     *
     * @return json
     */
    public function departamentos($provincia){
    	$departamentos = Departamento::where('id_provincia' , $provincia)->orderBy('nombre_departamento','ASC')->get();
    	return response()->json($departamentos);
    }

    /**
     * Devuelvo las localidades de un departamento determinado
     * @param char $provincia
     * @param char $departamento
     *
     * @return json
     */
    public function localidades($provincia , $departamento){
    	$localidades = Localidad::where('id_provincia' , $provincia)->where('id_departamento' , $departamento)->orderBy('nombre_localidad','ASC')->get();
    	return response()->json($localidades);
    }
}
