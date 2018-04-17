<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Prestaciones\PrestacionDR;
use App\Models\Prestaciones\PrestacionRequiereDR;
use App\Models\Prestaciones\PrestacionGrupoEtario;
use DB;
use Cache;
use Artisan;
use App\Jobs\RevisarDatosReportables;
use App\Models\Dw\DR\ResumenLote;

class PrestacionesDRController extends Controller
{
    //Tengo que sacarlo de la base
    private $ids_dr = [1,2,3,4,5,6,7,8,9,10,11,12,13,14];

   /**
    * Verifica que la prestacion que segun su codigo requiere dr realmente la requiera segun el grupo etario,
    * tenga los ids de dato reportable que requieren
    * y que los valores sean los correctos dentro de los rangos y en el formato especificado por el diccionario
    * de datos y la doiu.
    *
    * @return string
    */
    public function verificar($prestacion) {
	if($prestacion['fecha_prestacion'] < '2018-03-01') {
            return $this->segunDOIU20($prestacion);
	}
        return $this->segunDOIU32($prestacion);
    }

    public function segunDOIU20($prestacion)
    {
        $codigo_prestacion = $prestacion['codigo_prestacion'];

        //Corta la verificacion si pertenece a un grupo etario que no requiere datos reportables
        $ids_requeridos = $this->idsRequeridos($prestacion);

        if (!is_array($ids_requeridos)) {
            return ['success' => true,'message' => $ids_requeridos,'skip' => true];
        }

        $descripcion_grupo_etario = $ids_requeridos['descripcion_grupo_etario'];
        $ids_requeridos = $ids_requeridos['ids'];

        if ($prestacion['datos_reportables'] === null) {
            return ['success' => false,
            'errors' => 'Requiere: '.json_encode($ids_requeridos),
            'ids' => $ids_requeridos,
            'null' => true];
        }

        $datos_reportables = json_decode($prestacion['datos_reportables'], true);
        $ids_que_tiene = array_keys($datos_reportables);
        
	//Le saco todos los id de dato reportable que no existen
        $ids_que_tiene = array_intersect($this->ids_dr, $ids_que_tiene);

        //Surgio un problema con el id 4 solo es requerido para el grupo etario pero en menores de 1 anio
        if ($codigo_prestacion == 'CTC001A97') {
            //Necesito verificar la edad para saber si le tengo que sacar el id 4 como requerido
            $fecha_prestacion = $prestacion['fecha_prestacion'];
            $clave_beneficiario = $prestacion['clave_beneficiario'];
            $es_menor = DB::table('beneficiarios.beneficiarios')
            ->selectRaw("age('{$fecha_prestacion}', fecha_nacimiento) <= '1 year' as es_menor")
            ->where('clave_beneficiario', $clave_beneficiario)
            ->first()
            ->es_menor;
            //Tengo que remover de los dos
            if (!$es_menor) {
                $ids_requeridos = array_filter($ids_requeridos, function ($v) {
                    return $v != 4;
                });

                $ids_que_tiene = array_filter($ids_que_tiene, function ($v) {
                    return $v != 4;
                });
            }
        }

        //Corta la verificacion si no tiene ids validos mostrando cuales esperaba
        $diff = ['tiene' => $ids_que_tiene,'requiere' => $ids_requeridos];
        $ids_que_tiene = $this->tieneIdsValidos($ids_que_tiene, $ids_requeridos);

        if (!is_array($ids_que_tiene)) {
            return array_merge(
                $diff,
                ['success' => false,
                'errors' => "El grupo etario {$descripcion_grupo_etario} requiere los ids ".json_encode($ids_requeridos),
                'wrong' => true]
            );
        }
        //Verifico los rangos
        return $this->verificaRangos($ids_que_tiene, $prestacion, $datos_reportables, $descripcion_grupo_etario);
    }

    public function segunDOIU32() {
	return ['success' => false, 'motivo' => 'Todavia no se estan validando los datos para la doiu 32'];
    }

    /**
    * Verificar si el codigo de prestacion requiere declarar datos reportables
    *
    * @return boolean
    */
    public function requiereDatoReportable($codigo_prestacion)
    {
        $prestaciones = Cache::remember('prestacion-requiere-dr', 5, function () {
            return PrestacionRequiereDR::select('codigo_prestacion')
            ->get()
            ->map(function ($value) {
                return $value->codigo_prestacion;
            })
            ->toArray();
        });
        return in_array($codigo_prestacion, $prestaciones)?true:
        "El codigo de prestacion: {$codigo_prestacion} no requiere datos reportables.";
    }

    /**
     * Devuelve los ids que necesita segun grupo etario
     *
     * @return array
     */
    public function idsRequeridos($prestacion)
    {
        $grupo_identificado = false;
        $ids_requeridos = Cache::remember('ids-requeridos', 5, function () {
            return PrestacionRequiereDR::select('codigo_prestacion', 'grupo_etario', 'datos')
            ->get();
        });
        $ids_requeridos = $ids_requeridos->where('codigo_prestacion', $prestacion['codigo_prestacion']);
        $json = json_decode($ids_requeridos->first()->datos);

        $descripcion_grupo_etario = null;

        $tiene_grupo_etario = $ids_requeridos->first()->grupo_etario;

        if ($tiene_grupo_etario !== 'S') {
            //Porque no tiene un array de grupos etarios
            if (!$this->perteneceAlGrupoMujeres($prestacion)) {
                return 'Su grupo etario no requiere dato reportable.';
            } else {
                return ['ids' => $json->ids,'descripcion_grupo_etario' => "No diferencia por grupo etario\n"];                
            }
        }

        $max = count($json);
        $descripciones = Cache::remember('descripcion', 5, function () {
            return PrestacionGrupoEtario::select(
                'id_grupo_etario',
                DB::raw('clean_errors(descripcion::varchar) as descripcion')
            )
            ->get();
        });
        for ($i=0; $i < $max && !$grupo_identificado; $i++) {
            $grupo_etario = $json[$i]->id_grupo_etario;
            if ($this->perteneceA($grupo_etario, $prestacion)) {
                $descripcion_grupo_etario = $descripciones->where('id_grupo_etario', $grupo_etario)
                ->first()->descripcion;
                $grupo_identificado = true;
                return [
                    'ids' => $json[$i]->ids,
                    'descripcion_grupo_etario' => "Pertenece al grupo etario: {$descripcion_grupo_etario}"
                ];
            }
        }
        if (!$grupo_identificado) {
            return 'Su grupo etario no requiere dato reportable.';
        }
    }

    /**
     * Devuelve si tiene los ids que necesita o un mensaje especificando cuales no tiene
     *
     * @return string
     */
    public function tieneIdsValidos($ids_que_tiene, $ids_requeridos)
    {
	if(count(array_intersect($ids_requeridos, $ids_que_tiene)) === count($ids_requeridos)) {
	    return $ids_que_tiene;
	}
	
	return 'Requiere los datos reportables: '.json_encode($ids_requeridos).' pero tiene: '.json_encode($ids_que_tiene);
    }

    /**
     * Devuelve
     *
     * @return string
     */
    public function verificaRangos($ids_que_tiene, $prestacion, $datos_reportables, $descripcion_grupo_etario)
    {
        $mensajes = [$descripcion_grupo_etario];
        $fail = false;
        $rangos = Cache::remember('rangos', 5, function () {
            return PrestacionDR::select('id_dato_reportable', 'grupo_etario', 'datos')
            ->get();
        });

        $errores = [];
        $validados = [];
        foreach ($ids_que_tiene as $id => $dato) {
            $grupo_identificado = false;

            $rangos_para_id = $rangos->where('id_dato_reportable', $dato)->first();

            $json_rangos = json_decode($rangos_para_id->datos, true);

            //Verifico si tiene grupo etario o no
            if ($rangos_para_id->grupo_etario == 'S') {
                $max = count($json_rangos);
		//Corta en el primer grupo etario en el que lo encuentra
                for ($i=0; $i<$max && !$grupo_identificado; $i++) {
                    $grupo_etario = $json_rangos['datos_'.$i]['id_grupo_etario'];
                    //Verifico que pertenezca al grupo etario
                    if ($this->perteneceA($grupo_etario, $prestacion)) {
                        $grupo_identificado = true;
                        array_shift($json_rangos['datos_'.$i]);
                        $json_rangos = $json_rangos['datos_'.$i];
                    }
                }
                if (!$grupo_identificado) {
                    $mensaje = "No pertenece al grupo etario no necesita verificar rangos.";
                    array_push($mensajes, $mensaje);
                }
            } else {
                $json_rangos = $json_rangos['datos_0'];
                $grupo_identificado = true;
            }

            if ($grupo_identificado) {
                $mensaje = 'Id: '.json_encode($dato);
                if (!$this->validarRangos($json_rangos, $dato, $datos_reportables[$dato])) {
                    $fail = true;
                    $mensaje .= ' no corresponde con ';
                    array_push($errores, $dato);
                } else {
                    $mensaje.= ' validado con ';
                    array_push($validados, $dato);
                }
                $mensaje .= json_encode($json_rangos);
                array_push($mensajes, $mensaje);
            }
        }

        if ($fail) {
            return [
 	        'success' => false,
		'errors' => json_encode($mensajes),
	        'validados' => $validados,
	        'errores' => $errores
	    ];
        }

        return ['success' => true,'message' => json_encode($mensajes),'tiene' => $ids_que_tiene];
    }

    /**
    * Valida por clave de beneficiario,numero,clase y tipo de documento que el beneficiario pertenezca
    * al grupo etario al momento
    * que se dio la prestacion.
    *
    * @return boolean
    */
    private function perteneceA($grupo_etario, $prestacion)
    {
        $pertenece =  PrestacionGrupoEtario::select(
            DB::raw(
                "pertenece_a_grupo_etario({$grupo_etario},'".
                $prestacion['fecha_prestacion']."','".
                $prestacion['clave_beneficiario']."')"
            )
        )
        ->first()
        ->pertenece_a_grupo_etario;

        //Esto logra la division por grupo poblacional no solo por etario
        //Los codigos de prestacion que requieren el sexo F
        if ($pertenece && $grupo_etario == 4) {
            $pertenece = $this->perteneceAlGrupoMujeres($prestacion);
        }

        return $pertenece;
    }

    public function perteneceAlGrupoMujeres($prestacion)
    {
	//Pasar a tabla
        $depende_de_sexo = in_array($prestacion['codigo_prestacion'], [
            'APA002A98', 'APA002X75', 'APA002X80', 'APA002X76', 'LBL119A97', 'LBL119W78', 'CTC001A97', 'CTC009A97',
            'CTC010A97', 'IGR014A98', 'APA001A98', 'APA001X86', 'APA001X75', 'NTN002X75'
        ]);

	if(!$depende_de_sexo) return true;

        $sexo = DB::table('beneficiarios.beneficiarios')
            ->where('clave_beneficiario', $prestacion['clave_beneficiario'])
            ->select('sexo')
            ->first()
            ->sexo;

	return $sexo == 'F';
    }

    /**
    * Valida que el valor del dato reportable para ese id este dentro del rango o sea el valor que requiere
    *
    * Para la validacion de rangos hay casos especiales en los que hay que parsear el string
    * segun el formato que se haya pedido en el DOIU 20 que esta en el sirge junto al diccionario de datos
    *
    * @return boolean
    */
    private function validarRangos($rangos, $id_prestacion, $valor)
    {
        if (in_array('min', array_keys($rangos))) {
            return $valor >= $rangos['min'] && $valor <= $rangos['max'];
        }
        $max = count($rangos);
        $valores_posibles = array();
        for ($i = 1; $i <= $max; $i++) {
            array_push($valores_posibles, strtolower($rangos['valor_'.$i]));
        }

        switch ($id_prestacion) {
            case 3:
            return preg_match("/\d{1,3}\/\d{1,3}/", $valor);
            case 5:
            return preg_match("/\d{1,2}/", $valor);
            break;
            case 6:
            $matches = [];
            $match = preg_match("/[Cc]:(\d{1,2})\/[eEPp]:(\d{1,2})\/[Oo]:(\d{1,2})/", $valor, $matches);
            
            if ($match) {
                    //Saco el match de la expresion entera
                array_shift($matches);

                    //Convierto a integer todos los valores
                $mapped = array_map(
                    function ($value) {
                        return (int) $value;
                    },
                    $matches
                );

                $filtered = array_filter($mapped, function ($value) {
                    return $value >= 0  && $value <= 34;
                });

                if (count($filtered) != 3) {
                    info(json_encode($valor));
                    info(json_encode($matches));
                }
                return count($filtered) == 3;
            }
            return $match;
            break;
            case 7:
            return count($valor) == count(array_intersect(array_map("strtolower", $valor), $valores_posibles));
            break;
            default:
            return in_array(strtolower($valor), $valores_posibles);
            break;
        }
    }
}
