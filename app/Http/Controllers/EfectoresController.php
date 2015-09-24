<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NuevoEfectorRequest;

use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;

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
    	$hospitals = Efector::with(['estado'])->get();
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
                'compromisos',
                'emails',
                'telefonos',
                'referentes',
                'internet'
                ])
        ->where('id_efector' , $id)->find($id);

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
        
        DB::transaction(function() use ($ef, $te, $em, $re, $de, $ge, $cg, $ca, $r){
            $ef->save();
            $ef->telefonos()->save($te);
            $ef->emails()->save($em);
            $ef->referentes()->save($re);
            $ef->internet()->save($de);
            $ef->geo()->save($ge);
            if ($r->compromiso == 'S'){
                if ($r->indirecto == 'S'){
                    $ef->compromisos()->save($cg);
                    $ef->convenios()->save($ca);
                } else {
                    $ef->compromisos()->save($cg);
                }
            }

            return 'Se ha solicitado el alta con el CUIE: ' . $r->cuie;
        });
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
        $e = Efector::find($r->id);
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
      return view('efectores.edit' , $data);
    }
    
    public function getEditForm($cuie){
      $efector = Efector::where('cuie' , $cuie)->get();
      
    }

}
