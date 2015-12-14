<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Beneficiario;
use App\Models\Beneficiarios\Bajas;
use App\Models\Beneficiarios\CategoriasNacer;
use App\Models\Beneficiarios\Ceb;
use App\Models\Beneficiarios\Contacto;
use App\Models\Beneficiarios\Embarazados;
use App\Models\Beneficiarios\Geografico;
use App\Models\Beneficiarios\Indigenas;
use App\Models\Beneficiarios\Parientes;
use App\Models\Beneficiarios\Periodos;
use App\Models\Beneficiarios\Resumen;
use App\Models\Beneficiarios\Score;

use App\Models\Entidad;


class BeneficiariosController extends Controller
{
    /**
     * Devuelve el listado de beneficiarios
     *
     * @return null
     */
    public function index(){
    	$data = [
    		'page_title' => 'Beneficiarios'
    	];
    	return view('beneficiarios.listado' , $data);
    }

    /**
     * Devuelve un json para la datatable
     *
     * @return json
     */
    public function getListadoTabla(){
    	$benefs = Beneficiario::select('nombre','apellido','fecha_nacimiento','sexo','id_provincia_alta','clave_beneficiario')
            ->with([ 
                'geo' => function($q){ 
                    $q->with(['provincia' , 'ndepartamento' , 'localidad']); 
                }
            ])->where('clave_beneficiario','LIKE','240010000100493%')->take(20)->get();
        return Datatables::of($benefs)
            ->addColumn('action' , function($benef){
                return '<button clave-beneficiario="'.$benef->clave_beneficiario.'" class="ver-beneficiario btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
            })
            ->make(true);
    }


    /**
     * Devuelve la historia clinica del beneficiario
     * @param int $clave_beneficiario
     * 
     * @return null
     */
    public function historiaClinica($id , $back){
        $beneficiario = Beneficiario::select(                
                DB::raw('beneficiarios.*, extract(year from age(fecha_nacimiento)) as edad, extract(year from age(fecha_inscripcion)) as edad_inscripcion')                
                )->with([                
                'geo' => function($q){ 
                    $q->with(['provincia' , 'ndepartamento' , 'localidad']); 
                }, 'susPrestaciones' => function($q){
                    $q->with(['datosEfector',
                        'datosPrestacion' => function($q){ $q->with(['tipoDePrestacion']);} 
                    ])->orderBy('fecha_prestacion','desc');
                }
                ])
        ->find($id);
        //return json_encode($beneficiario);
        $data = [
            'page_title' => $beneficiario->nombre . ' ' . $beneficiario->apellido,
            'beneficiario' => $beneficiario,
        'back' => $back
        ];
        return view('beneficiarios.historia-clinica' , $data);
    }
}
