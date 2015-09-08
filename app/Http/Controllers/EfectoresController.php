<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Efector;

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
    public function detalle($id){
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
    		'efector' => $efector
    	];
    	return view('efectores.detalle' , $data);
    }

    /**
     * Devuelvo la vista para el alta de un efector nuevo
     *
     * @return null
     */
    public function alta(){
        $data = [
            'page_title' => 'Alta de nuevo efector'
        ];

        return view('efectores.alta' , $data);
    }
}
