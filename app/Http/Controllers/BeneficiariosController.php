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
use App\Models\Indicador;

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
    	$benefs = Beneficiario::select('nombre','apellido','fecha_nacimiento','sexo','numero_documento','clave_beneficiario');
        return Datatables::of($benefs)
            ->addColumn('action' , function($benef){
                return '<button clave-beneficiario="'.$benef->clave_beneficiario.'" class="ver-beneficiario btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
            })            
            ->make(true);
    }

    /**
     * Devuelve un json para la datatable
     *
     * @return json
     */
    public function busquedaBeneficiario($valor){        
        if(strlen($valor) == 16){
            $benefs = Beneficiario::select('nombre','apellido','fecha_nacimiento','sexo','numero_documento','clave_beneficiario')
        ->where('clave_beneficiario',$valor);
        return Datatables::of($benefs)
            ->addColumn('action' , function($benef){
                return '<button clave-beneficiario="'.$benef->clave_beneficiario.'" class="ver-beneficiario btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
            })            
            ->make(true);
        } 
        else
        {
            $benefs = Beneficiario::select('nombre','apellido','fecha_nacimiento','sexo','numero_documento','clave_beneficiario')
            ->where('numero_documento',$valor);
            return Datatables::of($benefs)
                ->addColumn('action' , function($benef){
                    return '<button clave-beneficiario="'.$benef->clave_beneficiario.'" class="ver-beneficiario btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
                })            
            ->make(true);
        }    
    }


    /**
     * Devuelve la historia clinica del beneficiario
     * @param int $clave_beneficiario
     * 
     * @return null
     */
    public function historiaClinica($id , $back){

        $row_periodo = Indicador::select(DB::raw('max(periodo)'))->get();                
        $max_periodo = $row_periodo[0]['max'];

        $beneficiario = Beneficiario::select(                
                DB::raw('beneficiarios.*, extract(year from age(fecha_nacimiento)) as edad, extract(year from age(fecha_inscripcion,fecha_nacimiento)) as edad_inscripcion, activo')                
                )->with([                
                'geo' => function($q){ 
                    $q->with(['provincia' , 'ndepartamento' , 'localidad']); 
                }, 'susPrestaciones' => function($q){
                    $q->with(['datosEfector',
                        'datosPrestacion' => function($q){ $q->with(['tipoDePrestacion']);} 
                    ])->orderBy('fecha_prestacion','desc');
                }
                ])->leftJoin('beneficiarios.periodos', function($join) use ($max_periodo)
                                {
                                    $join->on('beneficiarios.periodos.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->where('beneficiarios.periodos.periodo','=',$max_periodo); 
                                })            
        ->find($id);
                    
        $data = [
            'page_title' => $beneficiario->nombre . ' ' . $beneficiario->apellido,
            'beneficiario' => $beneficiario,
        'back' => $back
        ];
        return view('beneficiarios.historia-clinica' , $data);
    }
}
