<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NuevaSolicitudRequest;
use App\Http\Controllers\Controller;

use App\Models\Solicitudes\Grupo;
use App\Models\Solicitudes\Tipo;
use App\Models\Solicitudes\Prioridad;
use App\Models\Solicitudes\Operador;
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
        $data = [
            'page_title' => 'Mis solicitudes'
        ];
        return view('requests.user-requests' , $data);
    }

    /**
     * Devuelve el json para la datatable
     * 
     * @return json
     */
    public function myRequestsTable(){
        $requests = Solicitud::with(['tipos','estados'])->where('usuario_solicitante' , Auth::user()->id_usuario)->get();
        return Datatables::of($requests)
            ->addColumn('estado_label' , function($request){
                return '<span class="label label-'. $request->estados->css .'">'. $request->estados->descripcion .'</span>';
                //return 'DESAPARECIO';
            })
            ->addColumn('action' , function($request){
                return '<button id-solicitud="'. $request->id .'" class="view-solicitud btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button>';
            })
            ->make(true);
    }

    /**
     * Devuelve las solicitudes pendientes de asignación
     *
     * @return null
     */
    public function getSolicitudesNoAsignadas(){
        $data = [
            'page_title' => 'Asignación de solicitudes'
        ];
        return view('requests.asignaciones' , $data);
    }

    /**
     * Devuelve el json para la datatable
     * 
     * @return json
     */
    public function asignacionSolicitudesTable(){
        $requests = Solicitud::with(['tipos','estados','usuario','prioridades'])->where('usuario_asignacion', null)->get();
        return Datatables::of($requests)
            ->addColumn('estado_label' , function($request){
                return '<span class="label label-'. $request->estados->css .'">'. $request->estados->descripcion .'</span>';
                //return 'DESAPARECIO';
            })
            ->addColumn('action' , function($request){
                return '
                    <button id-solicitud="'. $request->id .'" class="view-solicitud btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>
                    <button id-solicitud="'. $request->id .'" class="asignar-solicitud btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Asignar</button>';
            })
            ->setRowClass(function ($request){
                return $request->prioridad == 5 ? 'danger' : '';
            })
            ->make(true);
    }

    /**
     * Asigna el operador a un requerimiento
     * @param Request $r
     *
     * @return string
     */
    public function postOperador(Request $r){
        $s = Solicitud::find($r->solicitud);
        $s->usuario_asignacion = $r->operador;
        $s->fecha_asignacion = date('Y-m-d H:i:s');
        if ($s->save()){
            return 'Se ha asignado el requerimiento al usuario solicitado';
        }
    }

    /**
     * Devuelve el detalle de una solicitud determinada
     * @param int $id
     *
     * @return null
     */
    public function getSolicitud($id , $back){
        $s = Solicitud::with(['tipos' => function($q){
            $q->with('grupos');
        },'estados','operador','prioridades'])->find($id);
        $data = [
            'solicitud' => $s,
            'back' => $back
        ];
        return view('requests.details' , $data);
    }

    /**
     * Retorna los operadores
     *
     * @return string
     */
    public function getOperadores($id){
        $s = Solicitud::with('tipos')->find($id);
        $operadores = Operador::with('usuario')->where('id_grupo' , $s->tipos->grupo)->get();
        $data = [
            'operadores' => $operadores,
            'id_solicitud' => $id
        ];
        //echo '<pre>',print_r($data),'</pre>';
        return view('requests.operadores' , $data);
    }
}
