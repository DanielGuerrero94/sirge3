<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp;
use SimpleXMLElement;


class WebServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return new GuzzleHttp\Client(['base_uri' => 'https://sisa.msal.gov.ar/sisa/services/rest/cmdb/obtener']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Devuelve una respuesta con los parámetros consultados
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function makeRequest($id)
    {
        //
    }

    /**
     * Devuelve una respuesta enviando los parámetros a consultar en siisa 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function siisaXMLRequest($nrdoc, $sexo = null)
    {
        $client = $this->create();
        //$url = 'https://sisa.msal.gov.ar/sisa/services/rest/cmdb/obtener?nrodoc=$nrodoc&usuario=fnunez&clave=fernandonunez';

        $url = 'https://sisa.msal.gov.ar/sisa/services/rest/cmdb/obtener?nrodoc='.$nrdoc.'&usuario=fnunez&clave=fernandonunez';
        
        if($sexo){
            $url = $url . '&sexo=' . $sexo;
        }

        $response = $client->get($url);

        /*echo $response->getStatusCode();

        echo '</br></br>';*/

        $datos = get_object_vars(new SimpleXMLElement($response->getBody()));

        echo json_encode($datos);        
    }
}
