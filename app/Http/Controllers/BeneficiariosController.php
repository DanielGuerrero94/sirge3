<?php

namespace App\Http\Controllers;

use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Usuario;

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
     * Datos para crear la tabla
     *
     * @return null
     */
    public function tabla(){
    	
    }
}
