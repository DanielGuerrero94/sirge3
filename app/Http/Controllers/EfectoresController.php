<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use DB;
use Excel;
use Mail;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NuevoEfectorRequest;

use App\Http\Controllers\Controller;

use App\Models\Efector;
use App\Models\Efectores\Categoria;
use App\Models\Efectores\Convenio;
use App\Models\Efectores\DependenciaAdministrativa;
use App\Models\Efectores\Descentralizacion;
use App\Models\Efectores\Email;
use App\Models\Efectores\Estado;
use App\Models\Efectores\Geografico;
use App\Models\Efectores\Gestion;
use App\Models\Efectores\Referente;
use App\Models\Efectores\Telefono;
use App\Models\Efectores\Tipo;
use App\Models\Efectores\Addenda;
use App\Models\Efectores\Addendas\Tipo as TipoAddenda;
use App\Models\Efectores\Ppac;
use App\Models\Efectores\Neonatal;
use App\Models\Efectores\Obstetrico;
use App\Models\Efectores\CategoriaPPAC;

use App\Models\Geo\Provincia;
use App\Models\Geo\Departamento;
use App\Models\Geo\Localidad;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class EfectoresController extends Controller
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
     * Devuelve la vista del listado
     *
     * @return null
     */
    public function listado(){
    	$data = [
    		'page_title' => 'Listado de efectores'
    	];
    	return view('efectores.listado' , $data);
    }

    /**
     * Devuelve un json para la datatable
     *
     * @return json
     */
    public function listadoTabla(){
    	$hospitals = Efector::with(['estado']);        
        return Datatables::of($hospitals)
        	->addColumn('label_estado' , function($hospital){
        		return '<span class="label label-'. $hospital->estado->css .'">'. $hospital->estado->descripcion .'</span>';
        	})
          ->addColumn('action' , function($hospital){
              return '<button id-efector="'. $hospital->id_efector .'" class="ver-efector btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
          })
          ->make(true);
    }

    /**
     * Devuelve el detalle del efector
     * @param int $id
     * 
     * @return null
     */
    public function detalle($id , $back){
    	$efector = Efector::with([
                'estado' , 
                'tipo' , 
                'categoria' ,
                'geo' => function($q){ 
                    $q->with(['provincia' , 'departamento' , 'localidad']); 
                },
                'dependencia',
                'compromiso',
                'emails',
                'telefonos',
                'referente',
                'internet',
                'convenio'
                ])
        ->find($id);

    	$data = [
    		'page_title' => $efector->nombre,
    		'efector' => $efector,
        'back' => $back
    	];
    	return view('efectores.detalle' , $data);
    }

    /**
     * Devuelvo la vista para el alta de un efector nuevo
     *
     * @return null
     */
    public function getAlta(){
        $dependencias = DependenciaAdministrativa::where('id_dependencia_administrativa' , '<>' , 5)->get();
        $tipos = Tipo::where('id_tipo_efector' , '<>' , 8)->get();
        $categorias = Categoria::where('id_categorizacion' , '<>' , 10)->get();
        $provincias = Provincia::all();
        $data = [
            'page_title' => 'Alta de nuevo efector',
            'tipos' => $tipos,
            'dependencias' => $dependencias,
            'categorias' => $categorias,
            'provincias' => $provincias
        ];

        return view('efectores.alta' , $data);
    }

    /**
     * Da de alta el efector
     * @param Request $r
     *
     * @return string
     */
    public function postAlta(NuevoEfectorRequest $r){
        $ge = new Geografico([
            'id_provincia' => $r->provincia,
            'id_departamento' => $r->departamento,
            'id_localidad' => $r->localidad,
            'ciudad' => $r->ciudad
            ]);

        $te = new Telefono([
            'numero_telefono' => $r->tel,
            'id_tipo_telefono' => 1,
            'observaciones' => $r->obs_tel
            ]);

        $em = new Email([
            'email' => $r->correo,
            'observaciones' => $r->obs_correo
            ]);

        $re = new Referente([
            'nombre' => $r->refer
            ]);

        $de = new Descentralizacion([
            'internet' => 'N',
            'factura_descentralizada' => 'N',
            'factura_on_line' => 'N'
            ]);

        $cg = new Gestion([
            'numero_compromiso' => $r->numero_compromiso,
            'firmante' => $r->firmante_compromiso,
            'fecha_suscripcion' => $r->compromiso_fsus,
            'fecha_inicio' => $r->compromiso_fini,
            'fecha_fin' => $r->compromiso_ffin,
            'pago_indirecto' => $r->indirecto
            ]);

        $ca = new Convenio([
            'numero_compromiso' => $r->numero_compromiso,
            'numero_convenio' => $r->convenio_numero,
            'firmante' => $r->convenio_firmante,
            'nombre_tercer_administrador' => $r->nombre_admin,
            'codigo_tercer_administrador' => $r->cuie_admin,
            'fecha_suscripcion' => $r->convenio_fsus,
            'fecha_inicio' => $r->convenio_fini,
            'fecha_fin' => $r->convenio_ffin
            ]);

        $ef = new Efector;
        $ef->cuie = $r->cuie;
        $ef->siisa = $r->siisa;
        $ef->nombre = $r->nombre;
        $ef->domicilio = $r->direccion;
        $ef->codigo_postal = $r->codigo_postal;
        $ef->denominacion_legal = $r->legal;
        $ef->id_tipo_efector = $r->tipo;
        $ef->rural = $r->rural;
        $ef->cics = $r->cics;
        $ef->id_categorizacion = $r->categoria;
        $ef->id_dependencia_administrativa = $r->dep_adm;
        $ef->dependencia_sanitaria = $r->dep_san;
        $ef->integrante = $r->integrante;
        $ef->compromiso_gestion = $r->compromiso;
        $ef->priorizado = $r->priorizado;
        $ef->id_estado = 2;
        
        $result = DB::transaction(function() use ($ef, $te, $em, $re, $de, $ge, $cg, $ca, $r){
            $ef->save();
            $ef->referente()->save($re);
            $ef->internet()->save($de);
            $ef->geo()->save($ge);

            if (strlen($r->tel))
              $ef->telefonos()->save($te);
            if (strlen($r->correo))
              $ef->emails()->save($em);

            if ($r->compromiso == 'S'){
                if ($r->indirecto == 'S'){
                    $ef->compromiso()->save($cg);
                    $ef->convenio()->save($ca);
                } else {
                    $ef->compromiso()->save($cg);
                }
            }
        });
        if (is_null($result)){

          Mail::send('emails.new-efector', ['efector' => $ef], function ($m) use ($ef) {
              $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
              $m->to('sistemasuec@gmail.com');
              $m->to('gustavo.hekel@gmail.com');
              $m->subject('Solicitud de alta de efector!');
          });
          
          return 'Se ha solicitado el alta del efector ' . $ef->nombre;
        } else {
          return 'Ha ocurrido un error';
        }
    }

    /**
     * Devuelvo la primer letra del cuie dependiendo de la provincia
     * @param $provincia char
     *
     * @return char
     */

    protected function getLetra($provincia){
        switch ($provincia) {
            case '01':
                $l = 'C';
                break;
            case '02':
                $l = 'B';
                break;
            case '03':
                $l = 'K';
                break;
            case '04':
                $l = 'X';
                break;
            case '05':
                $l = 'W';
                break;
            case '06':
                $l = 'E';
                break;
            case '07':
                $l = 'Y';
                break;
            case '08':
                $l = 'F';
                break;
            case '09':
                $l = 'M';
                break;
            case '10':
                $l = 'A';
                break;
            case '11':
                $l = 'J';
                break;
            case '12':
                $l = 'D';
                break;
            case '13':
                $l = 'S';
                break;
            case '14':
                $l = 'G';
                break;
            case '15':
                $l = 'T';
                break;
            case '16':
                $l = 'H';
                break;
            case '17':
                $l = 'U';
                break;
            case '18':
                $l = 'P';
                break;
            case '19':
                $l = 'L';
                break;
            case '20':
                $l = 'N';
                break;
            case '21':
                $l = 'Q';
                break;
            case '22':
                $l = 'R';
                break;
            case '23':
                $l = 'Z';
                break;
            case '24':
                $l = 'V';
                break;
        }
        return $l;
    }

    /**
     * Devuelve un cuie disponible
     * @param char $provincia
     *
     * @return string
     */
    public function getCuie($provincia){
        $disponible = false;
        $letra = $this->getLetra($provincia);
        $numero = 1;

        while (! $disponible){
            $cuie =  $letra . str_pad ($numero , 5 , '0' , STR_PAD_LEFT);
            if (! (Efector::where('cuie' , $cuie)->count())) {
                $disponible = true;
            } else {
                $numero ++;
            }
        }
        return $cuie;
    }

    /**
     * Devuelve un código siisa trucho
     * @param char $provincia
     *
     * @return bigint
     */
    public function getSiisa ($provincia){
        $sql = "
        select '99999999' || '{$provincia}' || lpad ((max (substring (siisa from 11 for 4)) :: numeric + 1 ) :: varchar , 4 , '0') as siisa
        from
          efectores.efectores
        where
          substring (siisa from 1 for 8) = '99999999'
          and substring (siisa from 9 for 2) = ?";
        $siisa = DB::select($sql , [$provincia]);
        if (($siisa[0]->siisa)){
            return $siisa[0]->siisa;
        } else {
            return '99999999' . $provincia . '0001';
        }
    }

    /**
     * Devuelve la vista para solicitar la baja del efector
     *
     * @return null
     */
    public function getBaja(){
        $data = [
            'page_title' => 'Solicitar baja de efector'
        ];

        return view('efectores.baja' , $data);
    }

    /**
     * Devuelve una sugerencia con CUIEs
     * @param string $cuie
     *
     * @return json
     */
    public function findCuie($cuie){
        $data = Efector::select('cuie')->where('cuie' , 'ilike' , $cuie . '%')->orderBy('cuie')->take(10)->lists('cuie');
        return response()->json($data);
    }

    /**
     * Solicita la baja de un efector
     * @param Request $r
     *
     * @return string
     */
    public function postBaja(Request $r){
        $e = Efector::where('cuie' , $r->cuie)->get()[0];
        $e->id_estado = 3;
        if ($e->save()){
            return 'Se ha solicitado la baja del efector ' . $r->cuie;
        }
    }

    /**
     * Devuelve la vista para la revisión de solicitudes
     * 
     * @return null
     */
    public function getRevision(){
        $data = [
            'page_title' => 'Revisión de solicitudes'
        ];
        return view('efectores.revision' , $data);
    }

    /**
     * Devuelve un json para la datatable
     *
     * @return json
     */
    public function getRevisionTabla(){
        $hospitals = Efector::with(['estado'])->whereIn('id_estado' , [2,3])->get();
        return Datatables::of($hospitals)
            ->addColumn('label_estado' , function($hospital){
                return '<span class="label label-'. $hospital->estado->css .'">'. $hospital->estado->descripcion .'</span>';
            })
            ->addColumn('action' , function($hospital){
                return '<button id-efector="'. $hospital->id_efector .'" class="ver-efector btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
            })
            ->addColumn('action_2' , function($hospital){
                if ($hospital->id_estado == 2){
                    return '<button id-efector="'. $hospital->id_efector .'" class="alta btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i> Aceptar alta</button>';
                } else {
                    return '<button id-efector="'. $hospital->id_efector .'" class="baja btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i> Aceptar baja</button>';
                }  
            })
            ->addColumn('action_3' , function($hospital){
                return '<button id-efector="'. $hospital->id_efector .'" class="rechazo btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Rechazar solicitud</button>';
            })
            ->make(true);
    }

    /**
     * Alta definitiva del efector
     * @param Request $r
     *
     * @return string
     */
    public function alta(Request $r){
        $e = Efector::find($r->id);
        $e->id_estado = 1;
        if ($e->save()){
            return 'Se ha dado el alta definitiva del efector : ' . $e->nombre;
        }
    }

    /**
     * Baja definitiva del efector
     * @param Request $r
     *
     * @return string
     */
    public function baja(Request $r){
        $e = Efector::findOrFail($r->id);
        $e->id_estado = 4;
        if ($e->save()){
            return 'Se ha dado la baja definitiva del efector : ' . $e->nombre;
        }
    }

    /**
     * Rechaza la solicitud
     * @param Request $r
     *
     * @return string
     */
    public function rechazo(Request $r){
        $e = Efector::find($r->id);
        if ($e->id_estado == 2){
            $e->id_estado = 5;
        } else if ($e->id_estado == 3){
            $e->id_estado = 1;
        }
        if ($e->save()){
            return 'Se ha reveertido la operación del efector : ' . $e->nombre;
        }
    }

    public function getEdit(){
      $data = [
        'page_title' => 'Modificación de efectores'
      ];
      return view('efectores.edit-find' , $data);
    }
    
    public function getEditForm($cuie){
      try {
        $e = Efector::where('cuie' , $cuie)->firstOrFail();
      } catch (ModelNotFoundException $e){
        return response('No se ha encontrado el efector solicitado' , 422);
      }

      $add_firmadas = Addenda::where('id_efector' , $e->id_efector)->lists('id_addenda');

      $dependencias = DependenciaAdministrativa::where('id_dependencia_administrativa' , '<>' , 5)->get();
      $tipos = Tipo::where('id_tipo_efector' , '<>' , 8)->get();
      $categorias = Categoria::where('id_categorizacion' , '<>' , 10)->get();      
      $provincias = Provincia::all();
      $departamentos = Departamento::all();
      $localidades = Localidad::all();
      $addendas = TipoAddenda::whereNotIn('id' , $add_firmadas)->get();
      $efector = Efector::with([
                'estado' , 
                'tipo' , 
                'categoria' ,
                'geo' => function($q){ 
                    $q->with(['provincia' , 'departamento' , 'localidad']); 
                },
                'dependencia',
                'compromiso',
                'emails',
                'telefonos',
                'referente',
                'internet',
                'convenio',
                'perinatal',
                'addendas' => function($q){
                  $q->with(['tipo']);
                }
                ])
        ->where('cuie' , $cuie)->firstOrFail();

        //return json_encode($efector);

      if (Auth::user()->id_entidad != 1){
        if (Auth::user()->id_provincia != $efector->geo->provincia->id_provincia){
          return response('Está tratando de editar un efector que no pertenece a su jurisdicción' , 422);
        }
      }

      $data = [
        'page_title' => 'Modificación de efector: ' . $efector->nombre,
        'tipos' => $tipos,
        'dependencias' => $dependencias,
        'categorias' => $categorias,
        'provincias' => $provincias,
        'efector' => $efector,
        'addendas' => $addendas
      ];
      return view('efectores.edit' , $data);
      
    }

    /**
     * Actualiza la información del efector
     * @param Request $r
     *

        TRATAR DE MEJORAR LA LÓGICA DE LA ACTUALIZACIÓN DE RELACIONES

     * @return string
     */
    public function postEdit(Request $r){

      $update = false;
      $ef = Efector::where('cuie' , $r->cuie)->firstOrFail();
      
      $ef->siisa = $r->siisa;
      $ef->id_tipo_efector = $r->tipo;
      $ef->nombre = $r->nombre;
      $ef->denominacion_legal = $r->legal;
      $ef->id_dependencia_administrativa = $r->dep_adm;
      $ef->dependencia_sanitaria = $r->dep_san;
      $ef->cics = $r->cics;
      $ef->rural = $r->rural;
      $ef->id_categorizacion = $r->categoria;
      $ef->integrante = $r->integrante;
      $ef->priorizado = $r->priorizado;
      $ef->compromiso_gestion = $r->compromiso;
      $ef->domicilio = $r->direccion;
      $ef->codigo_postal = $r->codigo_postal;
      if ($ef->save()){
        $update = true;
      } else {
        return 'Ha fallado la actualización de datos';
      }

      $ge = Geografico::find($ef->id_efector);
      $ge->id_departamento = $r->departamento;
      $ge->id_localidad = $r->localidad;
      $ge->ciudad = $r->ciudad;
      if ($ge->save()){
        $update = true;
      } else {
        return 'Ha fallado la actualización de datos';
      }

      $re = Referente::where('id_efector' , $ef->id_efector)->firstOrFail();
      $re->nombre = $r->refer;
      if ($re->save()){
        $update = true;
      } else {
        return 'Ha fallado la actualización de datos';
      }

      $de = Descentralizacion::find($ef->id_efector);
      $de->internet = $r->internet_efector;
      $de->factura_descentralizada = $r->factura_descentralizada;
      $de->factura_on_line = $r->factura_on_line;
      if ($de->save()){
        $update = true;
      } else {
        return 'Ha fallado la actualización de datos';
      }

      if (strlen($r->addenda_perinatal)){
        try {
          $pp = Ppac::findOrFail($ef->id_efector);
        } catch (ModelNotFoundException $e){
          $pp = new Ppac;
          $pp->id_efector = $ef->id_efector;
        }
        $pp->addenda_perinatal = $r->addenda_perinatal;
        $pp->fecha_addenda_perinatal = $r->fecha_addenda_perinatal;
        $pp->perinatal_ac = $r->perinatal_ac;
        if ($pp->save()){
          $update = true;
        } else {
          return 'Ha fallado la actualización de datos';
        }
      }

      if (strlen($r->tel)){
        try {
          $te = Telefono::where('id_efector' , $ef->id_efector)->firstOrFail();
        } catch (ModelNotFoundException $e){
          $te = new Telefono;
          $te->id_efector = $ef->id_efector;
        }
        $te->numero_telefono = $r->tel;
        $te->observaciones = $r->obs_tel;
        if ($te->save()){
          $update = true;
        } else {
          return 'Ha fallado la actualización de datos';
        }
      }

      if (strlen($r->correo)){
        try {
          $em = Email::where('id_efector' , $ef->id_efector)->firstOrFail();
        } catch (ModelNotFoundException $e){
          $em = new Email;
          $em->id_efector = $ef->id_efector;
        }
        $em->email = $r->correo;
        $em->observaciones = $r->obs_correo;
        if ($em->save()){
          $update = true;
        } else {
          return 'Ha fallado la actualización de datos';
        }
      }

      if ($r->integrante == 'S' && $r->compromiso == 'S'){
        try {
          $cg = Gestion::findOrFail($ef->id_efector);
        } catch (ModelNotFoundException $e){
          $cg = new Gestion;
          $cg->id_efector = $ef->id_efector;
        }
        $cg->numero_compromiso = $r->numero_compromiso;
        $cg->firmante = $r->firmante_compromiso;
        $cg->fecha_suscripcion = $r->compromiso_fsus;
        $cg->fecha_inicio = $r->compromiso_fini;
        $cg->fecha_fin = $r->compromiso_ffin;
        $cg->pago_indirecto = $r->indirecto;
        if ($cg->save()){
          $update = true;
        } else {
          return 'Ha fallado la actualización de datos';
        }
      }

      if ($r->indirecto == 'S'){
        try {
          $ca = Convenio::findOrFail($ef->id_efector);
        } catch (ModelNotFoundException $e){
          $ca = new Convenio;
          $ca->id_efector = $ef->id_efector;
        }
        $ca->numero_convenio = $r->convenio_numero;
        $ca->firmante = $r->convenio_firmante;
        $ca->nombre_tercer_administrador = $r->nombre_admin;
        $ca->codigo_tercer_administrador = $r->cuie_admin;
        $ca->fecha_suscripcion = $r->convenio_fsus;
        $ca->fecha_inicio = $r->convenio_fini;
        $ca->fecha_fin = $r->convenio_ffin;
        $ca->numero_compromiso = $r->numero_compromiso;
        if ($ca->save()){
          $update = true;
        } else {
          return 'Ha fallado la actualización de datos';
        }
      }

      if (strlen($r->tipo_addenda)){
        $ad = new Addenda;
        $ad->id_efector = $ef->id_efector;
        $ad->id_addenda = $r->tipo_addenda;
        $ad->fecha_addenda = $r->fecha_firma;
        if ($ad->save()){
          $update = true;
        }
      }

      if ($update) {
        return 'Se ha actualizado la información del efector : ' . $ef->nombre;
      }
    }

    /**
     * Descarga la tabla de efectores
     *
     * @return null
     */
    public function generarTabla(){

      $efectores = Efector::with([
        'estado' , 
        'tipo' , 
        'categoria' ,
        'geo' => function($q){ 
            $q->with(['provincia' , 'departamento' , 'localidad']); 
        },
        'dependencia',
        'compromiso',
        'emails',
        'telefonos',
        'referente',
        'internet',
        'convenio',
        'neonatal' => function($q){
          $q->with('info');
        },
        'obstetrico' => function($q){
          $q->with('info');
        },
        'addendas' => function($q){
          $q->with('tipo');
        }
        ])
        //->where('id_estado' , 1)
        //->take(50)
        ->orderBy('cuie' , 'asc')
        ->get();
      
      $data = ['efectores' => $efectores];

      Excel::create('Efectores_SUMAR' , function ($e) use ($data){
        $e->sheet('Tabla_SUMAR' , function ($s) use ($data){
          $s->setHeight(1, 20);
          $s->setColumnFormat([
              'B' => '0'
            ]);
          $s->loadView('efectores.tabla' , $data);
        });
      })->store('xls');
    }

    /**
     * Decargar la tabla generada
     *
     * @return null
     */
    public function descargarTabla(){
      return response()->download('../storage/exports/Efectores_SUMAR.xls');
    }

}
