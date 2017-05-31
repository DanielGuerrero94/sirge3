<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp;
use SimpleXMLElement;
use App\Models\Beneficiario;
use App\Models\InscriptosPadronSisa;
use App\Models\ErrorPadronSisa;
use Exception;
use DB;
use Schema;
use App\Models\Excepciones;

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

     /**
     * Devuelve una respuesta enviando los parámetros a consultar en siisa 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cruceSiisaXMLRequest($nrdoc, $client)
    {
        
        if(!InscriptosPadronSisa::find($nrdoc)){

            $url = 'https://sisa.msal.gov.ar/sisa/services/rest/cmdb/obtener?nrodoc='.$nrdoc.'&usuario=fnunez&clave=fernandonunez';                    
                        
            try {
                //throw new Exception("Error Processing Request", 1);                
                $response = $client->get($url);                
            } catch (Exception $e) {
                return json_encode(array('error' => 'SI', 'mensaje' => 'Error Code '. $e->getCode() .': ' . $e->getMessage()));                                   
            }    

                $datos = get_object_vars(new SimpleXMLElement($response->getBody()));                
            return json_encode($datos);             
        }
        else{
            return null;
        }
    }

     /**
     * Devuelve una respuesta enviando los parámetros a consultar en siisa 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function convertirEnTexto($valor){
        if(gettype($valor) == "object"){
            if(isset($valor->{'0'})){
                if($valor->{'0'} == ' ' || $valor->{'0'} == ''){
                    return null;
                }
                else{
                    return (string) $valor->{'0'};   
                }
            }
            else{
                return null;
            }                
        }        
        else{
            if($valor == 'NULL'){
                return null;
            }
            else{
                return (string) $valor;
            }       
        }
    }

     /**
     * Busca los documentos de los beneficiarios que no están cruzados con siisa y guarda sus datos.
     *     
     * @return "Resultado"
     */
    public function cruzarBeneficiariosConSiisa(){

        $ch = curl_init();      
        set_time_limit(0);
        curl_setopt($ch, CURLOPT_TIMEOUT,30000);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_close($ch);

        $start = microtime(true);

        $client = $this->create();

        $cantidad = 10;

        $dt = \DateTime::createFromFormat('Ym' , date('Ym'));
        $dt->modify('-2 months');
        $periodo = intval($dt->format('Ym'));

        DB::statement("CREATE TABLE IF NOT EXISTS siisa.temporal_migracion_siisa(numero_documento character varying(14) PRIMARY KEY);");

        $documentos = Beneficiario::join('beneficiarios.geografico as g' , 'beneficiarios.beneficiarios.clave_beneficiario' , '=' , 'g.clave_beneficiario')
                                  ->join('beneficiarios.periodos as p', function($join) use ($periodo)
                                  {
                                       $join->on('beneficiarios.beneficiarios.clave_beneficiario', '=',  'p.clave_beneficiario');
                                       $join->where('p.periodo','=', $periodo);
                                  })                        
                                  ->leftjoin('siisa.inscriptos_padron as i' , 'beneficiarios.beneficiarios.numero_documento' , '=' , 'i.nrodocumento')
                                  ->leftjoin('siisa.error_padron_siisa as e' , 'beneficiarios.beneficiarios.numero_documento' , '=' , 'e.numero_documento')
                                  ->leftjoin('siisa.temporal_migracion_siisa as t' , 'beneficiarios.beneficiarios.numero_documento' , '=' , 't.numero_documento')    
                                  ->where('id_provincia_alta' , '22')
                                  ->where('clase_documento' , 'P')                                  
                                  //->whereIn('g.id_localidad', [1366,1386,1390,1402,1411])                                
                                  ->whereNull('i.nrodocumento')
                                  ->whereNull('t.numero_documento')                                  
                                  ->whereNull('e.numero_documento')                                                     
                                  ->take($cantidad)                                  
                                  ->select('beneficiarios.beneficiarios.numero_documento')    
                                  ->groupBy('beneficiarios.beneficiarios.numero_documento')                              
                                  ->get()
                                  ->toArray();                                

        if(count($documentos) == 0){
            if(DB::table('siisa.temporal_migracion_siisa')->count() == 0){
                Schema::dropIfExists('siisa.temporal_migracion_siisa');
            }
            die("No quedan más beneficiarios a procesar de dicha provincia");
        }                                            
        
        try {
            DB::table("siisa.temporal_migracion_siisa")->insert($documentos);            
        } catch (Exception $e) {
            $excepcion = new Excepciones();
            $excepcion->clase = (string) get_class();
            $excepcion->metodo = (string) __FUNCTION__;
            $excepcion->error = json_encode(array("codigo" => $e->getCode(),"mensaje" => $e->getMessage()));
            $excepcion->save();
            unset($excepcion);
        }                                        

        foreach ($documentos as $documento){                    
            $datos_benef = $this->cruceSiisaXMLRequest((string) $documento['numero_documento'], $client);                            
            if($datos_benef && $datos_benef <> '{}'){                                                             
                $data = (array) json_decode($datos_benef);                            
                $data = (object) $data;
                $data->nrodocumento = $documento['numero_documento'];                                                           
                if(isset($data->resultado)){                    
                    if ($data->resultado == 'OK') {                                
                        $resultado[] = $this->guardarDatos($data);                       
                        if (sizeof($resultado) % 1000 == 0){
                            try {
                                InscriptosPadronSisa::insert($resultado);    
                            } catch (Exception $e) {
                                $excepcion = new Excepciones();
                                $excepcion->clase = (string) get_class();
                                $excepcion->metodo = (string) __FUNCTION__;
                                $excepcion->error = json_encode(array("codigo" => $e->getCode(),"mensaje" => $e->getMessage()));
                                $excepcion->save();
                                unset($excepcion);
                            }            
                            unset($resultado);
                            $resultado = [];
                        } 
                    }
                    else{                        
                        $devolucion = $this->guardarError($data, $documento['numero_documento']);
                        if($devolucion){
                            $error[] = $devolucion;    
                        }
                        unset($devolucion);                        
                    }    
                }
                else{
                    $devolucion = $this->guardarError($data, $documento['numero_documento']);
                    if($devolucion){
                        $error[] = $devolucion;    
                    }
                    unset($devolucion);
                }  
            }
            unset($datos_benef);
            unset($data);                      
        }        
        if (isset($resultado) ? sizeof($resultado) : FALSE){
            try {                
                InscriptosPadronSisa::insert($resultado);
            } catch (Exception $e) {                
                $excepcion = new Excepciones();
                $excepcion->clase = (string) get_class();
                $excepcion->metodo = (string) __FUNCTION__;
                $excepcion->error = json_encode(array("codigo" => $e->getCode(),"mensaje" => $e->getMessage()));
                $excepcion->save();
                unset($excepcion);
            }            
            unset($resultado);
        }        
        
        if (isset($error) ? sizeof($error) : FALSE){
            try {
                ErrorPadronSisa::insert($error);
            } catch (Exception $e) {
                $excepcion = new Excepciones();
                $excepcion->clase = (string) get_class();
                $excepcion->metodo = (string) __FUNCTION__;
                $excepcion->error = json_encode(array("codigo" => $e->getCode(),"mensaje" => $e->getMessage()));
                $excepcion->save();
                unset($excepcion);
            }            
            unset($error);
        }                        
        unset($documento);
        unset($documentos);

        $end = microtime(true) - $start;

        if(DB::table('siisa.temporal_migracion_siisa')->count() <= $cantidad){
            Schema::dropIfExists('siisa.temporal_migracion_siisa');
        }

        DB::statement("INSERT INTO siisa.tiempo_proceso (fecha,tiempo, cantidad) VALUES (now(), ?, ?)", [$end, $cantidad]);

        echo "Los beneficiarios se han insertado correctamente. Tiempo: " . $end . "\n";
    }

     /**
     * Guarda los datos encontrados en el webservice del siisa
     *
     * @param  object  $datos
     * @return json_encode($datos)
     */
    public function guardarDatos($datos){

        //die(var_dump($datos));
                
        //$inscripto = new InscriptosPadronSisa();
        $inscripto['id'] = $this->convertirEnTexto($datos->id);  
        $inscripto['codigosisa'] = $this->convertirEnTexto($datos->codigoSISA);
        $inscripto['identificadorenaper'] = $this->convertirEnTexto($datos->identificadoRenaper);
        $inscripto['padronsisa'] = $this->convertirEnTexto($datos->PadronSISA);
        $inscripto['tipodocumento'] = $this->convertirEnTexto($datos->tipoDocumento);
        $inscripto['nrodocumento'] = intval($this->convertirEnTexto($datos->nroDocumento));
        $inscripto['apellido'] = $this->convertirEnTexto($datos->apellido);
        $inscripto['nombre'] = $this->convertirEnTexto($datos->nombre);
        $inscripto['sexo'] = $this->convertirEnTexto($datos->sexo);
        $inscripto['fechanacimiento'] = $this->convertirEnTexto($datos->fechaNacimiento);
        $inscripto['estadocivil'] = $this->convertirEnTexto($datos->estadoCivil);
        $inscripto['provincia'] = $this->convertirEnTexto($datos->provincia);
        $inscripto['departamento'] = $this->convertirEnTexto($datos->departamento);
        $inscripto['localidad'] = $this->convertirEnTexto($datos->localidad);
        $inscripto['domicilio'] = $this->convertirEnTexto($datos->domicilio);
        $inscripto['pisodpto'] = $this->convertirEnTexto($datos->pisoDpto);
        $inscripto['codigopostal'] = $this->convertirEnTexto($datos->codigoPostal);
        $inscripto['paisnacimiento'] = $this->convertirEnTexto($datos->paisNacimiento);
        $inscripto['provincianacimiento'] = $this->convertirEnTexto($datos->provinciaNacimiento);
        $inscripto['localidadnacimiento'] = $this->convertirEnTexto($datos->localidadNacimiento);
        $inscripto['nacionalidad'] = $this->convertirEnTexto($datos->nacionalidad);
        $inscripto['fallecido'] = $this->convertirEnTexto($datos->fallecido);
        $inscripto['fechafallecido'] = $this->convertirEnTexto($datos->fechaFallecido);
        $inscripto['donante'] = $this->convertirEnTexto($datos->donante);
        $inscripto['created_at'] = date('Y-m-d H:i:s');
        $inscripto['updated_at'] = date('Y-m-d H:i:s');
        return $inscripto;
    }

     /**
     * Guarda el error de la búsqueda del beneficiario.
     *
     * @param  object $datos
     * @return bool
     */
    public function guardarError($datos, $documento){             
        
        $devolver = array();
        $noEncontrado = ErrorPadronSisa::where('numero_documento',$documento)->first();
        
        if($noEncontrado){                
            $noEncontrado->error = $this->convertirEnTexto($datos->resultado);                   
            try {
                $noEncontrado->save();
                unset($noEncontrado);
                return FALSE;
            } catch (QueryException $e) {
                echo json_encode($e);
            }                        
        }
        else{                        
            $devolver['numero_documento'] = $documento;                
            $devolver['error'] = isset($datos->error) ? $datos->mensaje : $this->convertirEnTexto($datos->resultado);
            $devolver['created_at'] = date('Y-m-d H:i:s');
            $devolver['updated_at'] = date('Y-m-d H:i:s');
            return $devolver;            
        }                    
    }

    /**
     * Borra la tabla temporal
     *
     * 
     * 
     */
    public function borrarTablaTemporal(){             
        Schema::dropIfExists('siisa.temporal_migracion_siisa');        
    }
}
