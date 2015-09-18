<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EstadisticasController extends Controller
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
     * Devuelve la vista principal para los graficos
     *
     * @return null
     */
    public function getGraficos(){
    	$data = [
    		'page_title' => 'Gráficos'
    	];
    	return view('estadisticas.graficos.main' , $data);
    }

    /**
     * Devuelve un grafico seleccionado
     * @param int $id
     *
     * @return view
     */
    public function getGrafico($id){
    	$data = [
    		'page_title' => 'Grafico 1'
    	];
    	return view('estadisticas.graficos.graficos.1' , $data);
    }
}
