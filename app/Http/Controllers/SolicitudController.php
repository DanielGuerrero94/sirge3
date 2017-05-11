<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use PDF;
use Mail;
use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NuevaSolicitudRequest;
use App\Http\Controllers\Controller;

use App\Models\Solicitudes\Grupo;
use App\Models\Solicitudes\Tipo;
use App\Models\Solicitudes\Prioridad;
use App\Models\Solicitudes\Operador;
use App\Models\Solicitud;
use App\Models\Solicitudes\Adjunto;
use App\Models\Usuario;

class SolicitudController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(){
    	$this->middleware('auth' , ['except' => 'finalizarSolicitud']);
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
            'prioridades' => $prioridades,
            'id_usuario' => Auth::user()->id_usuario
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
        $s->fecha_solicitud = date("Y/m/d");
        $s->fecha_estimada_solucion = $r->fecha;
        $s->prioridad = $r->prioridad;
        $s->tipo = $r->tipo_solicitud;
        $s->descripcion_solicitud = $r->descripcion;        
        if($r->id_adjunto != "null"){
            $s->id_adjunto = $r->id_adjunto;    
        }
        else{
            $s->id_adjunto = NULL;   
        }        
        if ($s->save()){
            
            $s->usuario_solicitante;
            $user = Usuario::select('nombre','usuario','email','id_usuario','id_provincia','id_entidad')->with(['provincia','entidad'])->where('id_usuario',$s->usuario_solicitante)->first();        
            Mail::send('emails.new-solicitud', ['usuario' => $user], function ($m) use ($user) {
                  $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
                  $m->to('javier.minsky@gmail.com');
                  $m->to('sirgeweb@gmail.com');
                  $m->to('rodrigo.cadaval.sumar@gmail.com');                  
                  $m->subject('Nuevo requerimiento!');
            });

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
        $requests = Solicitud::with(['tipos','estados','usuario','prioridades'])->where('estado', 1)->get();
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
        $s->estado = 2;
        $s->usuario_asignacion = $r->operador;
        $s->fecha_asignacion = date('Y-m-d H:i:s');
        if ($s->save()){
            $this->notificarAsignacion($s->id);
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
        },'estados','operador','prioridades','adjuntos'])->find($id);
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
        $operadores = Operador::with(['usuario' => function($q){
            $q->orderBy('id_usuario');
        }])->where('id_grupo' , $s->tipos->grupo)->where('habilitado' , 'S')->get();
        $data = [
            'operadores' => $operadores,
            'id_solicitud' => $id
        ];
        //echo '<pre>',print_r($data),'</pre>';
        return view('requests.operadores' , $data);
    }

    /**
     * Envia un email al usuario con el operador asignado a su requerimiento
     * @param int $id
     *
     * @return bool
     */
    protected function notificarAsignacion($id){
        $path = base_path() . '/storage/pdf/asignaciones/' . $id . '.pdf';
        $user = Auth::user();
        $s = Solicitud::with(['usuario','operador'])->find($id);
        $data = [
            'solicitud' => $s
        ];
        $pdf = PDF::loadView('pdf.asignacion' , $data);
        $pdf->save($path);

        Mail::send('emails.request-asignacion', ['usuario' => $user], function ($m) use ($user , $path , $id , $s) {
            $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
            $m->to($s->usuario->email)->cc($s->operador->email);
            $m->subject('Asignación requerimiento Nº ' . $id);
            $m->attach($path);
        });
    }

    /**
     * Devuelve el listado con las tareas asignadas al usuario
     *
     * @return null
     */
    public function getPendientes(){
        $data = [
            'page_title' => 'Solicitudes asignadas'
        ];
        return view('requests.pendientes' , $data);
    }

    /**
     * Devuelve el json para la datatable
     * 
     * @return json
     */
    public function solicitudesPendientesTable(){
        $requests = Solicitud::with(['tipos','estados','usuario','prioridades'])->where('estado', 2)->where('usuario_asignacion' , Auth::user()->id_usuario)->get();
        return Datatables::of($requests)
            ->addColumn('estado_label' , function($request){
                return '<span class="label label-'. $request->estados->css .'">'. $request->estados->descripcion .'</span>';
                //return 'DESAPARECIO';
            })
            ->addColumn('action' , function($request){
                return '
                    <button id-solicitud="'. $request->id .'" class="view-solicitud btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>
                    <button id-solicitud="'. $request->id .'" class="cerrar-solicitud btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i> Cerrar</button>';
            })
            ->setRowClass(function ($request){
                return $request->prioridad == 5 ? 'danger' : '';
            })
            ->make(true);
    }

    /**
     * Devuelve el formulario para el cierre de la solicitud
     * @param int $id
     *
     * @return string
     */
    public function getCerrar($id){
        $s = Solicitud::find($id);
        $data = [
            's' => $s
        ];
        return view('requests.cerrar' , $data);
    }

    /**
     * Cierra la solicitud y avisa por mail al usuario
     * @param Request $r
     * @param int $id
     *
     * @return string 
     */
    public function postCerrar(Request $r , $id){
        $s = Solicitud::with(['usuario','operador'])->find($id);
        $s->fecha_solucion = date('Y-m-d H:i:s');
        $s->descripcion_solucion = $r->solucion;
        $s->estado = 3;
        $s->hash = uniqid();
        if ($s->save()){
            $path = base_path() . '/storage/pdf/soluciones/' . $id . '.pdf';
            $user = Auth::user();
            $data = [
                'solicitud' => $s
            ];
            $pdf = PDF::loadView('pdf.cierre' , $data);
            $pdf->save($path);

            Mail::send('emails.request-cierre', ['usuario' => $user , 'id' => $id , 'hash' => $s->hash], function ($m) use ($user , $path , $id , $s) {
                $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
                $m->to($s->usuario->email);
                $m->subject('Cierre requerimiento Nº ' . $id);
                $m->attach($path);
            });

            return 'Se ha cerrado el requerimiento y se avisó al usuario por email';
        }
    }

    /**
     * Finaliza la solicitud con el ok del usuario
     * @param int $id
     *
     * @return null
     */
    public function finalizarSolicitud($id , $hash){
        $s = Solicitud::where('id' , $id)->where('hash' , $hash)->firstOrFail();
        $s->estado = 4;
        $s->fecha_cierre_usuario = date('Y-m-d H:i:s');
        if ($s->save()){
            return view('requests.gracias');
        }
    }

    /**
     * Devuelve un listado completo
     *
     * @return null
     */
    public function listado(){
        $data = [
            'page_title' => 'Listado completo'
        ];
        return view('requests.listado' , $data);
    }

    /**
     *  Devuelve el json para la datatable
     *
     * @return json
     */
    public function listadoTable(){
        $requests = Solicitud::with(['tipos','estados','usuario','prioridades'])->get();
        return Datatables::of($requests)
            ->addColumn('estado_label' , function($request){
                return '<span class="label label-'. $request->estados->css .'">'. $request->estados->descripcion .'</span>';
            })
            ->addColumn('action' , function($request){
                $col = '<button id-solicitud="'. $request->id .'" class="view-solicitud btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
                if ($request->estado == 3){
                    $col .= ' <button id-solicitud="'. $request->id .'" class="notificar-solicitud btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Notificar</button>';
                }
                return $col;
            })
            ->setRowClass(function ($request){
                return $request->prioridad == 5 ? 'danger' : '';
            })
            ->make(true);
    }

    /**
     * Notifica por email al usuario el cierre del requerimiento
     * @param int $id
     *
     * @return string
     */
    public function notificarCierre($id){
        $s = Solicitud::with(['usuario','operador'])->find($id);
        $path = base_path() . '/storage/pdf/soluciones/' . $id . '.pdf';
        $user = Auth::user();
        $data = [
            'solicitud' => $s
        ];
        $pdf = PDF::loadView('pdf.cierre' , $data);
        $pdf->save($path);

        Mail::send('emails.request-cierre', ['usuario' => $user , 'id' => $id , 'hash' => $s->hash], function ($m) use ($user , $path , $id , $s) {
            $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
            $m->to($s->usuario->email);
            $m->subject('Cierre requerimiento Nº ' . $id);
            $m->attach($path);
        });

        return 'Se ha notificado al usuario por email';
    }

    /**
     * Devuelve la ruta donde guardar el archivo
     * @param int $id
     *
     * @return string
     */
    protected function getName($route = FALSE){        
        if ($route)
            return '../storage/uploads/solicitudes';
        else
            return 'solicitudes';
    }

    /**
     * Guarda el archivo en el sistema
     * @param $r Request
     *
     * @return json
     */
    public function attachDocument(Request $r){     

        $nombre_archivo = uniqid() . '.' . $r->file->getClientOriginalExtension();

        //return var_dump(array($nombre_archivo, $r->all()));

        $destino = $this->getName(TRUE);
        $a = new Adjunto;                
        $a->nombre_original_solicitante = $r->file->getClientOriginalName();
        $a->nombre_actual_solicitante = $nombre_archivo;
        $a->size_solicitante = $r->file->getClientSize();                

        try {
            $r->file('file')->move($destino , $nombre_archivo);
        } catch (FileException $e){
            $a->delete();
            return response()->json(['success' => 'false',
                                            'errors'  => "Ha ocurrido un error: ". $e->getMessage()]);
        }
        if ($a->save()){                                
            return response()->json(['success' => 'true', 'id_adjunto' => $a->id_adjunto, 'file' => $r->file->getClientOriginalName()]);
            unset($s); 
        }
        else{
            return response()->json(['success' => 'false',
                                            'errors'  => 'Hubo un error al guardar el archivo']);
        }
    }

    /**
     * Guarda el adjunto de respuesta de la solicitud
     * @param $r Request
     *
     * @return json
     */
    public function attachDocumentResponse(Request $r){     
        
        $destino = $this->getName(TRUE);

        $s = Solicitud::find($r->id_solicitud);        
        if(!($a = Adjunto::find($s->id_adjunto))){
            $a = new Adjunto();
        }

        $nombre_archivo = 'REQ-' . $r->id_solicitud . ' SOLUCION' . '.' .$r->file->getClientOriginalExtension();      
        $a->nombre_original_respuesta = $r->file->getClientOriginalName();
        $a->nombre_actual_respuesta = $nombre_archivo; 
        $a->size_respuesta = $r->file->getClientSize();                        

        try {
            $r->file('file')->move($destino , $nombre_archivo);
        } catch (FileException $e){
            $a->delete();
            return response()->json(['success' => 'false',
                                            'errors'  => "Ha ocurrido un error: ". $e->getMessage()]);
        }
        if ($a->save()){
            
            if(!$s->id_adjunto){
                $s->id_adjunto = $a->id_adjunto;
            } 
            $s->save();

            return response()->json(['success' => 'true', 'id_adjunto' => $a->id_adjunto, 'file' => $r->file->getClientOriginalName()]);
            unset($s); 
        }
        else{
            return response()->json(['success' => 'false',
                                            'errors'  => 'Hubo un error al guardar el archivo']);
        }

        unset($s);
        unset($a);
    }

    /**
     * Decargar adjunto asociado a solicitud
     *
     * @return null
     */
    public function downloadAdjuntoSolicitante($id_adjunto){
        $adjunto = Adjunto::find($id_adjunto);
        return response()->download('../storage/uploads/solicitudes/'.$adjunto->nombre_actual_solicitante);
    }

    /**
     * Decargar adjunto de cierre de la solicitud
     *
     * @return null
     */
    public function downloadAdjuntoCierre($id_adjunto){
        $adjunto = Adjunto::find($id_adjunto);
        return response()->download('../storage/uploads/solicitudes/'.$adjunto->nombre_actual_respuesta);
    }

    /**
     * Devuelve JSON para la datatable del ranking de solicitudes realizadas
     *
     * @return json
     */
    public function getRanking(){
        $data = [
            'page_title' => 'Ranking solicitudes'
        ];
        return view('admin.estadisticas.ranking_solicitudes' , $data);
    }

    /**
     * Devuelve JSON para la datatable del ranking de solicitudes realizadas
     *
     * @return json
     */
    public function getRankingSolicitantes(){
        $solicitantes = Solicitud::join('sistema.usuarios as u' , 'solicitudes.solicitudes.usuario_solicitante' , '=' , 'u.id_usuario')
            ->select(DB::raw('quitarhtml(u.nombre) as nombre'),DB::raw('count(*) as cantidad'))
            ->where('estado','>',2)
            ->groupBy('u.nombre')
            ->orderBy(DB::raw('count(*)'),'DESC');
        
        return Datatables::of($solicitantes)->make(true);
    }

    /**
     * Devuelve JSON para la datatable del ranking de cierre de solicitudes por operadores
     *
     * @return json
     */
    public function getRankingOperadores(){
        $operadores = Solicitud::join('sistema.usuarios as u' , 'solicitudes.solicitudes.usuario_asignacion' , '=' , 'u.id_usuario')
            ->select(DB::raw('quitarhtml(u.nombre) as nombre'),DB::raw('count(*) as cantidad'))
            ->where('estado','>',2)
            ->groupBy('u.nombre')
            ->orderBy(DB::raw('count(*)'),'DESC');
        
        return Datatables::of($operadores)->make(true);
    }
}
