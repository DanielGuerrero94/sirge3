<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Solicitudes\Grupos;
use App\Models\Solicitudes\Tipos;

class SolicitudController extends Controller
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
     * Devuelve la vista para el ingreso de una nueva solicitud
     *
     * @return null
     */
    public function getNuevaSolicitud(){
        $grupos = Grupos::all();
    	$data = [
    		'page_title' => 'Ingreso de nueva solicitud',
            'sectores' => $grupos
    	];
    	return view('requests.new' , $data);
    }

    /**
     * Devuelve la vista con los tipos de solicitud para el grupo seleccionado
     * @param int $grupo
     *
     * @return null
     */
    public function getTipos($id){
        $tipos = Tipos::where('grupo' , $id)->get();
        $data = [
            'tipos' => $tipos
        ];
        return view ('common.select-tipo-solicitud' , $data);
    }
}
