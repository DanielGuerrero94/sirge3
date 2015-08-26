<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NuevaSolicitudRequest;
use App\Http\Controllers\Controller;

use App\Models\Solicitudes\Grupo;
use App\Models\Solicitudes\Tipo;
use App\Models\Solicitudes\Prioridad;
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
        $grupos = Grupo::all();
        $prioridades = Prioridad::all();
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
        $tipos = Tipo::where('grupo' , $id)->get();

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

    /**
     * Devuelve el listado de requerimientos ingresados
     * 
     * @return null
     */
    public function getMisSolicitudes(Request $r){
        $s = Solicitud::with(['tipos','estados'])->orderBy('id','desc')->paginate(5);
        $s->setPath('mis-solicitudes');
        $data = [
            'page_title' => 'Mis solicitudes',
            'solicitudes' => $s
        ];
        return view('requests.user-requests' , $data);
    }

    /**
     * Devuelve el detalle de una solicitud determinada
     * @param int $id
     *
     * @return null
     */
    public function getSolicitud($id){
        $s = Solicitud::with(['tipos' => function($q){
            $q->with('grupos');
        },'estados','operador','prioridades'])->find($id);
        $data = [
            'solicitud' => $s
        ];
        // echo '<pre>',print_r($s),'</pre>';
        return view('requests.details' , $data);
    }
}
