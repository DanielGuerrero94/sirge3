<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NuevaSolicitudRequest;
use App\Http\Controllers\Controller;

use App\Models\Solicitudes\Grupos;
use App\Models\Solicitudes\Tipos;
use App\Models\Solicitudes\Prioridades;
use App\Models\Solicitud;

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
        $prioridades = Prioridades::all();
        $data = [
            'page_title' => 'Ingreso de nueva solicitud',
            'sectores' => $grupos,
            'prioridades' => $prioridades
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

    /**
     * Ingresa un nuevo requerimiento
     * @param Request $r
     *
     * @return string
     */
    public function postNuevaSolicitud (NuevaSolicitudRequest $r){
        $s = new Solicitud;
        $s->referencia = strlen($r->ref) ? $r->ref : 0;
        $s->usuario_solicitante = Auth::user()->id_usuario;
        $s->fecha_estimada_solucion = $r->fecha;
        $s->prioridad = $r->prioridad;
        $s->tipo = $r->tipo_solicitud;
        $s->descripcion_solicitud = $r->descripcion;
        if ($s->save()){
            return 'Se ha enviado su solicitud. Nos estaremos comunicando con usted a la brevedad. Muchas gracias';
        }

    }
}
