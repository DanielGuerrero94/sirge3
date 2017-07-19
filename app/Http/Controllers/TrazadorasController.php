<?php

namespace App\Http\Controllers;

use ErrorException;
use Exception;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use DB;
use Datatables;
use Session;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;
use App\Models\ErrorSubida;
use App\Models\Lote;
use App\Models\Rechazo;
use App\Models\Trazadoras\Header;

use App\Models\Geo\Provincia;

class TrazadorasController extends Controller
{
    private 
        $rules = 
        [
            'Trz_01' => [
                'efector' => 'required|exists:efectores.efectores,cuie',
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:12',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_control' => 'date_format:Y-m-d',
                'edad_gestacional' => 'integer',
                'fecha_ultima_menstruacion' => 'date_format:Y-m-d',
                'fecha_probable_parto' => 'date_format:Y-m-d',
                'peso' => 'required|numeric',
                'tension_arterial' => 'size:7',
                'es_control' => 'size:1',
                'id_registro_provincial' => 'integer',
                'id_registro' => 'integer'
            ],
            'Trz_02' => [                
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
                'numero_documento' => 'required|max:12',
                'orden' => 'integer|max:2',
                'departamento_residencia' => 'size:3',
                'fecha_probable_parto_usada' => 'date_format:Y-m-d',
                'observaciones' => 'max:500'
            ],
            'Trz_02_Det' => [
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:12',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_control' => 'date_format:Y-m-d',
                'edad_gestacional' => 'integer|digits_between:1,2',
                'fecha_ultima_menstruacion' => 'date_format:Y-m-d',
                'fecha_probable_parto' => 'date_format:Y-m-d',
                'peso' => 'required|numeric|max:7',
                'tension_arterial' => 'size:7',
                'es_control' => 'size:1',
                'id_registro_provincial' => 'integer',
                'id_registro' => 'integer'
            ],
            'Trz_03' => [
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:12',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'orden' => 'integer|digits_between:1,2',
                'peso_nacimiento' => 'numeric',                
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_04' => [                
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
                'numero_documento' => 'required|max:12',
                'orden' => 'integer|digits_between:1,2',
                'departamento_residencia' => 'size:3',
                'fecha_probable_parto_usada' => 'date_format:Y-m-d',
                'observaciones' => 'max:500'
            ],
            'Trz_04_Det' => [
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:12',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'departamento_residencia' => 'size:3',
                'fecha_control' => 'date_format:Y-m-d',                
                'peso' => 'numeric',
                'talla' => 'integer|digits_between:1,3',
                'perimetro_cefalico' => 'numeric',
                'percentilo_peso_edad' => 'size:1',
                'percentilo_talla_edad' => 'size:1',
                'percentilo_perimetro_cefalico_edad' => 'size:1',
                'percentilo_peso_talla' => 'size:1',
                'tension_arterial' => 'size:7',            
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_05' => [                
                'codigo_departamento' => 'size:3',
                'denominador' => 'integer|digits_between:1,6',
                'casos' => 'integer|digits_between:1,6',
                'porcentaje' => 'numeric'                
            ],
            'Trz_06' => [
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:12',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_diagnostico' => 'date_format:Y-m-d',
                'fecha_denuncia' => 'date_format:Y-m-d',
                'cardiopatia_detectada' => 'size:3',                
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_07' => [
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_realizacion_TSOMF' => 'date_format:Y-m-d',
                'resultado_TSOMF' => 'size:1',                
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_08' => [                
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d'                
            ],
            'Trz_08_Det' => [
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_vacunacion_cuadruple_bacteriana' => 'date_format:Y-m-d',
                'fecha_vacunacion_antipoliomielitica' => 'date_format:Y-m-d',                
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_09' => [                
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d'                
            ],
            'Trz_09_Det' => [
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_vacunacion_triple_bacteriana' => 'date_format:Y-m-d',
                'fecha_vacunacion_triple_viral' => 'date_format:Y-m-d',
                'fecha_vacunacion_antipoliomielitica' => 'date_format:Y-m-d',                
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_10' => [                
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
                'numero_documento' => 'required|max:12',
                'orden' => 'integer|digits_between:1,2',
                'departamento_residencia' => 'size:3',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'observaciones' => 'max:500'              
            ],
            'Trz_10' => [  
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:12',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'departamento_residencia' => 'size:3',
                'fecha_control' => 'date_format:Y-m-d',                
                'peso' => 'numeric',
                'talla' => 'integer|digits_between:1,3',
                'perimetro_cefalico' => 'numeric',
                'percentilo_peso_edad' => 'size:1',
                'percentilo_talla_edad' => 'size:1',
                'percentilo_perimetro_cefalico_edad' => 'size:1',
                'percentilo_peso_talla' => 'size:1',
                'tension_arterial' => 'size:7',            
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_11' => [
                'efector' => 'required|exists:efectores.efectores,cuie',
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_asistencia_taller' => 'date_format:Y-m-d',
                'tema_taller' => 'max:4',
                'indice_conocimiento' => 'max:5',
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_12' => [
                'efector' => 'required|exists:efectores.efectores,cuie',
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_diagnostico_histologico' => 'date_format:Y-m-d',
                'diagnostico' => 'size:1',
                'fecha_inicio_tratamiento' => 'date_format:Y-m-d',
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_13' => [
                'efector' => 'required|exists:efectores.efectores,cuie',
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_diagnostico_histologico' => 'date_format:Y-m-d',
                'carcinoma' => 'size:1',
                'tamaño' => 'max:2',
                'ganglios_linfaticos' => 'max:2',
                'metastasis' => 'max:2',
                'estadio' => 'max:4',
                'fecha_inicio_tratamiento' => 'date_format:Y-m-d',
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_14' => [
                'efector' => 'required|exists:efectores.efectores,cuie',
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'orden' => 'max:2',
                'fecha_defuncion' => 'date_format:Y-m-d',
                'fecha_auditoria_muerte' => 'date_format:Y-m-d',
                'fecha_parto_o_interrupcion_embarazo' => 'date_format:Y-m-d',
                'diagnostico' => 'max:4',
                'estadio' => 'max:4',            
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ],
            'Trz_15' => [
                'efector' => 'required|exists:efectores.efectores,cuie',        
                'clave_beneficiario' => 'size:16',
                'clase_documento' => 'in:P,A,C',
                'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',              
                'numero_documento' => 'required|max:9',
                'apellido' => 'max:50',
                'nombre' => 'max:50',
                'sexo' => 'in:M,F',
                'fecha_nacimiento' => 'date_format:Y-m-d',
                'fecha_realizacion_TSOMF' => 'date_format:Y-m-d',
                'resultado_TSOMF' => 'size:1',                
                'id_registro_provincial' => 'required|integer',
                'id_registro' => 'integer'
            ]               
        ],
        $_header = [
            'trazadora' => 'required|numeric|max:2',        
            'casos_positivos' => 'required|numeric',
            'fecha_generacion' => 'date_format:Y-m-d',
            'hora_generacion' => 'size:8',              
            'usuario_generacion' => 'max:25',
            'version_aplicativo' => 'max:10'
        ],
        $_data_header = [
            'trazadora', 
            'casos_positivos',
            'fecha_generacion',
            'hora_generacion',
            'usuario_generacion',
            'version_aplicativo'
        ],
        $_data = [
            'Trz_01' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_control',
                'edad_gestacional',
                'fecha_ultima_menstruacion',
                'fecha_probable_parto',
                'peso',
                'tension_arterial',
                'es_control',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_02' => [
                'tipo_documento',
                'numero_documento',
                'orden',
                'departamento_residencia',
                'fecha_probable_parto_usada',
                'observaciones'
            ],
            'Trz_02_Det' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_control',
                'edad_gestacional',
                'fecha_ultima_menstruacion',
                'fecha_probable_parto',
                'peso',
                'tension_arterial',
                'es_control',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_03' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'orden',
                'peso_nacimiento',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_04' => [
                'tipo_documento',
                'numero_documento',
                'orden',
                'departamento_residencia',
                'fecha_probable_parto_usada',
                'observaciones'
            ],
            'Trz_04_Det' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'departamento_residencia',
                'fecha_control',
                'peso',
                'talla',
                'perimetro_cefalico',
                'percentilo_peso_edad',
                'percentilo_talla_edad',
                'percentilo_perimetro_cefalico_edad',
                'percentilo_peso_talla',
                'tension_arterial',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_05' => [
                'codigo_departamento',
                'denominador',
                'casos',
                'porcentaje'
            ],
            'Trz_06' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_diagnostico',
                'fecha_denuncia',
                'cardiopatia_detectada',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_07' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_realizacion_TSOMF',
                'resultado_TSOMF',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_08' => [
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento'
            ],
            'Trz_08_Det' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_vacunacion_cuadruple_bacteriana',
                'fecha_vacunacion_antipoliomielitica',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_09' => [
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento'
            ],
            'Trz_09_Det' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_vacunacion_triple_bacteriana',
                'fecha_vacunacion_triple_viral',
                'fecha_vacunacion_antipoliomielitica',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_10' => [
                'tipo_documento',
                'numero_documento',
                'orden',
                'departamento_residencia',
                'fecha_nacimiento',
                'observaciones'
            ],
            'Trz_10' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'departamento_residencia',
                'fecha_control',
                'peso',
                'talla',
                'perimetro_cefalico',
                'percentilo_peso_edad',
                'percentilo_talla_edad',
                'percentilo_perimetro_cefalico_edad',
                'percentilo_peso_talla',
                'tension_arterial',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_11' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_asistencia_taller',
                'tema_taller',
                'indice_conocimiento',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_12' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_diagnostico_histologico',
                'diagnostico',
                'fecha_inicio_tratamiento',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_13' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_diagnostico_histologico',
                'carcinoma',
                'tamaño',
                'ganglios_linfaticos',
                'metastasis',
                'estadio',
                'fecha_inicio_tratamiento',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_14' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'orden',
                'fecha_defuncion',
                'fecha_auditoria_muerte',
                'fecha_parto_o_interrupcion_embarazo',
                'diagnostico',
                'estadio',
                'id_registro_provincial',
                'id_registro'
            ],
            'Trz_15' => [
                'efector',
                'clave_beneficiario',
                'clase_documento',
                'tipo_documento',
                'numero_documento',
                'apellido',
                'nombre',
                'sexo',
                'fecha_nacimiento',
                'fecha_realizacion_TSOMF',
                'resultado_TSOMF',
                'id_registro_provincial',
                'id_registro'
            ]
        ],
        $_resumen = [
            'insertados' => 0,
            'rechazados' => 0,
            'modificados' => 0
        ],
        $_error = [
            'lote' => '',
            'registro' => '',
            'motivos' => ''
        ],
        $_info_archivo = [
            'trazadora' => '', 
            'provincia' => '',
            'periodo' => 0,
            'detalle' => 'N',
            'tipo_regla' => ''            
        ],
        $_rules_archivo = [
            'trazadora' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12,13,14,15',
            'provincia' => 'required|exists:geo.provincias,id_provincia',
            'periodo' => 'required|integer|digits:6',
            'detalle' => 'required|size:1',
            'tipo_regla' => 'required|max:25'            
        ];

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Crea un nuevo lote
     * @param int $id_subida
     *
     * @return int
     */
    protected function nuevoLote($id_subida){
        $l = new Lote;
        $l->id_subida = $id_subida;
        $l->id_usuario = Auth::user()->id_usuario;
        $l->id_provincia = Auth::user()->id_provincia;
        $l->registros_in = 0;
        $l->registros_out = 0;
        $l->registros_mod = 0;
        $l->id_estado = 1;
        $l->save();
        return $l->lote;
    }

    /**
     * Actualiza el lote con los datos procesados
     * @param int $lote
     * @param array $resumen
     *
     * @return bool
     */
    protected function actualizaLote($lote , $resumen) {
        $l = Lote::findOrFail($lote);
        $l->registros_in = $resumen['insertados'];
        $l->registros_out = $resumen['rechazados'];
        $l->registros_mod = $resumen['modificados'];
        $l->fin = 'now';
        return $l->save();
    }

    /**
     * Actualiza el archivo con los datos procesados
     * @param int $id
     *
     * @return bool
     */
    protected function actualizaSubida($subida) {
        $s = Subida::findOrFail($subida);
        $s->id_estado = 3;
        return $s->save();
    }


    /**
     * Abre un archivo y devuelve un handler
     * @param int $id
     *
     * @return resource
     */
    protected function abrirArchivo($id){
        $info = Subida::findOrFail($id);        

        try {
            $fh = fopen ('/var/www/html/sirge3/storage/uploads/trazadoras/' . $info->nombre_actual , 'r');
            $this->identificarTrazadora($info->nombre_original);
        } catch (ErrorException $e) {
            return false;
        }
        return $fh;
    }

    /**
     * Identifica con el nombre del archivo la provincia, trazadora y periodo a la que corresponde.
     * @param string $nombre
     *
     * @return resource
     */
    public function identificarTrazadora($nombre, $carga_archivo = null){
        $archivo = explode('_', $nombre);        
        $trazadora = str_replace('Trz','',$archivo[0]);
        $periodo = intval($archivo[2] . str_pad(intval(str_replace(strtoupper('.TXT'),'',$archivo[3])),2,'0',STR_PAD_LEFT));
        if(count($archivo) == 5){
            $detalle = strtoupper(explode('.',$archivo[4])[0]) == 'DET' ? 'S' : 'N';
        }
        else{
            $detalle = 'N';
        }        
        $this->_info_archivo['trazadora'] = $trazadora;
        $this->_info_archivo['provincia'] = $archivo[1];
        $this->_info_archivo['periodo'] = $periodo;
        $this->_info_archivo['detalle'] = $detalle;
        $this->_info_archivo['tipo_regla'] = 'Trz_' . $trazadora . ($detalle == 'S' ? '_Det' : '');
        
        $v1 = Validator::make($this->_info_archivo , $this->_rules_archivo);
        if ($v1->fails() && empty($carga_archivo)) {
            throw new Exception('El nombre del archivo no cumple con las reglas' . '<br \>' . json_encode($this->_info_archivo));
        }
        elseif ($v1->fails() && !empty($carga_archivo)) {
            return array('status' => 'error', 'detalle' => json_encode($this->_info_archivo, JSON_PRETTY_PRINT));
        }            
    }

    /**
     * Guarda los datos del header a procesar en la base de datos. 
     * @param array $header
     *
     * @return resource
     */
    public function procesarHeader($header){
        $header = array_combine($this->_data_header, $header);
        $header['version_aplicativo'] = trim($header['version_aplicativo'] , "\r\n");

        $v2 = Validator::make($header , $this->_header);
        if ($v2->fails()) {
            throw new Exception('El header del archivo no es correcto' . '<br \>' . json_encode($header));
        }        
        return $header;        
    }

    public function procesarArchivo($id_subida)
    {
        $fh = $this->abrirArchivo($id_subida);     
        
        if (!$fh){
            return response()->json(['success' => 'false', 'errors'  => "El archivo no ha podido procesarse"]);
        }
                
        $lote = Lote::where('id_subida',$id_subida)->first()->lote;
   
        $nro_linea = 1;

        $header = preg_split("/[\t]/", fgets($fh));
        
        Subida::where('id_subida',$id_subida)->update(['id_estado' => 1]);               
             
        try {                                
                $ins_header = $this->procesarHeader($header);                                
                
                $new_header = new Header();
                $new_header->lote = $lote;
                $new_header->trazadora = $ins_header['trazadora'];
                $new_header->casos_positivos = $ins_header['casos_positivos'];
                $new_header->fecha_generacion = $ins_header['fecha_generacion'];
                $new_header->hora_generacion = $ins_header['hora_generacion'];
                $new_header->usuario_generacion = $ins_header['usuario_generacion'];
                $new_header->version_aplicativo = $ins_header['version_aplicativo'];
                $new_header->save();

            } catch (Exception $e) {                        
                return response()->json(['success' => 'false', 'errors'  => $e->getMessage()]);
            }
    
        /*    
        while (!feof($fh)){

            $nro_linea++;
            $linea = preg_split("/[\t]/", trim(fgets($fh) , "\r\n"));         
                array_push($linea, $lote);
                $this->_error['lote'] = $lote;
                $this->_error['created_at'] = date("Y-m-d H:i:s");      
                if(count($this->_data) == count($linea)){
                    $comprobante_raw = array_combine($this->_data, $linea);
                    if (strlen($comprobante_raw['fecha_debito_bancario']) < 10){
                        $comprobante_raw['fecha_debito_bancario'] = '1900-01-01';
                    }
                    $v = Validator::make($comprobante_raw , $this->_rules);
                    if ($v->fails()) {
                        $this->_resumen['rechazados'] ++;                       
                        $this->_error['registro'] = json_encode($comprobante_raw);
                        $this->_error['motivos'] = json_encode($v->errors());                                   
                        try {
                            Rechazo::insert($this->_error);                         
                        } catch (QueryException $e) {                                                                                   
                            if ($e->getCode() == 23505){
                                $this->_error['motivos'] = '{"pkey" : ["Registro ya informado"]}';
                            }
                            else if ($e->getCode() == 22021 || $e->getCode() == '22P05'){
                                                $this->_error['registro'] = json_encode(parent::vaciarArray($comprobante_raw));                                     
                                                $this->_error['motivos'] = json_encode(array('code' => $e->getCode(), 'linea' => $nro_linea, 'error' => 'El formato de caracteres es inválido para la codificación UTF-8. No se pudo convertir. Intente convertir esas lineas a UTF-8 y vuelva a procesarlas.'));                                           
                            }
                            else {                                          
                                $this->_error['motivos'] = json_encode(array('code' => $e->getCode(), 'error' => $e->getMessage()));
                            }
                            Rechazo::insert($this->_error);
                        }                       
                    } else {
                        try {
                            Comprobante::insert($comprobante_raw);
                            $this->_resumen['insertados'] ++;
                        } catch (QueryException $e) {                           
                            $this->_resumen['rechazados'] ++;
                            $this->_error['lote'] = $lote;
                            $this->_error['registro'] = json_encode($comprobante_raw);
                            $this->_error['created_at'] = date("Y-m-d H:i:s");
                            if ($e->getCode() == 23505){
                                $this->_error['motivos'] = '{"pkey" : ["Registro ya informado"]}';
                            }
                            else if ($e->getCode() == 22021 || $e->getCode() == '22P05'){
                                                $this->_error['registro'] = json_encode(parent::vaciarArray($comprobante_raw));                                     
                                                $this->_error['motivos'] = json_encode(array('code' => $e->getCode(), 'linea' => $nro_linea, 'error' => 'El formato de caracteres es inválido para la codificación UTF-8. No se pudo convertir. Intente convertir esas lineas a UTF-8 y vuelva a procesarlas.'));                                           
                            }
                            else {                                          
                                $this->_error['motivos'] = json_encode(array('code' => $e->getCode(), 'error' => $e->getMessage()));
                            }
                            Rechazo::insert($this->_error);
                        }
                    }
                }
                else{
                    $this->_resumen['rechazados'] ++;                   
                    $this->_error['registro'] = json_encode($linea);
                    $this->_error['motivos'] = json_encode('La cantidad de columnas ingresadas en la linea no es la correcta');                 
                }                           
        }
        $this->actualizaLote($lote , $this->_resumen);
        $this->actualizaSubida($id_subida);
        return response()->json(array('success' => 'true', 'data' => $this->_resumen));*/
    }
}
