<?php

namespace App\Http\Controllers;

use Datatables;

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
    	$benefs = Beneficiario::with(['provincia'])->take(100)->skip(100)->get();
        return Datatables::of($benefs)
            ->addColumn('action' , function($benef){
                return '<button id-beneficiario="'.$benef->clave_beneficiario.'" class="ver-beneficiario btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
            })
            ->make(true);
    }
}
