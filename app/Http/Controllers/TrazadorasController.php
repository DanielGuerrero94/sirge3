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

use App\Models\Geo\Provincia;
use App\Models\Trazadoras\Trazadora_1;
use App\Models\Trazadoras\Trazadora_2;
use App\Models\Trazadoras\Trazadora_3;
use App\Models\Trazadoras\Trazadora_4;
use App\Models\Trazadoras\Trazadora_5;
use App\Models\Trazadoras\Trazadora_6;
use App\Models\Trazadoras\Trazadora_7;
use App\Models\Trazadoras\Trazadora_8;
use App\Models\Trazadoras\Trazadora_9;
use App\Models\Trazadoras\Trazadora_10;
use App\Models\Trazadoras\Trazadora_11;
use App\Models\Trazadoras\Trazadora_12;
use App\Models\Trazadoras\Trazadora_13;
use App\Models\Trazadoras\Trazadora_14;
use App\Models\Trazadoras\Trazadora_15;
use App\Models\Trazadoras\Header;
use App\Models\Trazadoras\Beneficiario as TrzBenef;

class TrazadorasController extends AbstractPadronesController
{
    private $_rules =
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
                'peso' => 'required|numeric',
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
                'fecha_nacimiento' => 'date_format:Y-m-d',
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
                'tamano' => 'max:2',
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
            'trazadora' => 'required|numeric|max:20',
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
                'fecha_nacimiento',
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
        $_new_beneficiarios = [],
        $_update_beneficiarios = [],
        $_rules_archivo = [
            'trazadora' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12,13,14,15',
            'provincia' => 'required|exists:geo.provincias,id_provincia',
            'periodo' => 'required|integer|digits:6',
            'detalle' => 'required|size:1',
            'tipo_regla' => 'required|max:25'
        ],
        $_process_data = [
            'FILE_DIR' => '/var/www/html/sirge3/storage/uploads/trazadoras/',
            'FILE_NAME' => '',
            'FILE_PATH' => '',
            'TABLE_NAME' => '',
            'PERIOD' => '',
            'NUMBER_LOTE' => '',
            'TRAZADORA_NUMBER' => '',
            'LOGIC_DIR' => '/var/www/html/sirge3/storage/uploads/trazadoras/process_logic/',
            'LOGIC_FILE_NAME' => ''
        ];

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new instance of Trazadoras.
     *
     * @return Model instance
     */
    public function newInstance($value)
    {
        $model = "App\Models\Trazadoras\Trazadora_".$value;
        return new $model;
    }

    /**
     * Devuelve el nombre del modelo a utilizar.
     *
     * @return Model
     */
    public function getModel($value)
    {
        return "App\Models\Trazadoras\Trazadora_".$value;
    }
    
    /**
     * Devuelve el nombre del modelo a utilizar.
     *
     * @return Model
     */
    public function getTempTable($value)
    {
        return "trazadoras.trz_".$value."_temp";
    }

    /**
     * Filtra los campos de beneficiario de la trazadora.
     *
     * @return array
     */
    public function filtrarDatosBeneficiario($array_trz)
    {
        return array_filter($array_trz, function ($k) {
                                return !in_array($k, [
                                                        'clave_beneficiario'
                                                        ,'clase_documento'
                                                        ,'tipo_documento'
                                                        ,'apellido'
                                                        ,'nombre'
                                                        ,'sexo'
                                                        ,'fecha_nacimiento'
                                                    ]);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Filtra los campos de beneficiario de la trazadora.
     *
     * @return array
     */
    public function getDatosBeneficiario($array_trz)
    {
        return array_filter(
            $array_trz,
            function ($k1) {
                //Retorno los datos del beneficiario que existan respecto a esos campos que trajo la trazadora
                    return in_array($k1, [
                                            'clave_beneficiario'
                                            ,'clase_documento'
                                            ,'tipo_documento'
                                            ,'apellido'
                                            ,'nombre'
                                            ,'sexo'
                                            ,'fecha_nacimiento'
                                        ]);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Filtra los campos de la trazadora.
     *
     * @return array
     */
    public function filtrarDatosTrazadora($array_trz)
    {
        $array = $this->_data[str_replace('_Det', '', $this->_info_archivo['tipo_regla'])];
        array_push($array, "periodo");
        array_push($array, "lote");
        return array_filter($array_trz, function ($k) use ($array) {
                                return in_array($k, $array);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Carga los datos del beneficiario en caso de no existir
     *
     * @return void
     */
    public function cargarBeneficiario($array_trz)
    {
        $benef = TrzBenef::find($array_trz['numero_documento']);
        $array_benef = $this->getDatosBeneficiario($array_trz);
        if (!$benef) {
            $array_benef['numero_documento'] = $array_trz['numero_documento'];
            $array_benef['created_at'] = date("Y-m-d H:i:s");
            $array_benef['updated_at'] = date("Y-m-d H:i:s");
            $this->_new_beneficiarios[] = $array_benef;
        }
        /*if (!$benef) {
            $benef = new TrzBenef();
            $array_benef['numero_documento'] = $array_trz['numero_documento'];
        }
        foreach ($array_benef as $key => $value) {
            if ($value) {
                $benef->$key = $value;
            }
        }
        $benef->save();*/
        unset($benef);
    }

    /**
     * Crea un nuevo lote
     * @param int $id_subida
     *
     * @return int
     */
    protected function nuevoLote($id_subida)
    {
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
    protected function actualizaLote($lote, $resumen)
    {
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
    protected function actualizaSubida($subida)
    {
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
    protected function abrirArchivo($id)
    {
        $info = Subida::findOrFail($id);

        try {
            $fh = fopen('/var/www/html/sirge3/storage/uploads/trazadoras/' . $info->nombre_actual, 'r');
            $result = $this->identificarTrazadora($info->nombre_original);
            if ($result['status'] == 'error') {
                return false;
            }
            unset($result);
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
    public function identificarTrazadora($nombre, $carga_archivo = null)
    {
        $archivo = explode('_', $nombre);
        $trazadora = str_replace('Trz', '', $archivo[0]);
        $periodo = intval($archivo[2] . str_pad(intval(str_replace(strtoupper('.TXT'), '', $archivo[3])), 2, '0', STR_PAD_LEFT));
        if (count($archivo) == 5) {
            $detalle = strtoupper(explode('.', $archivo[4])[0]) == 'DET' ? 'S' : 'N';
        } else {
            $detalle = 'N';
        }
            $this->_info_archivo['trazadora'] = intval($trazadora);
            $this->_info_archivo['provincia'] = $archivo[1];
            $this->_info_archivo['periodo'] = $periodo;
            $this->_info_archivo['detalle'] = $detalle;
            $this->_info_archivo['tipo_regla'] = 'Trz_' . $trazadora . ($detalle == 'S' ? '_Det' : '');

            $v1 = Validator::make($this->_info_archivo, $this->_rules_archivo);
        if ($v1->fails() && empty($carga_archivo)) {
            throw new Exception('El nombre del archivo no cumple con las reglas' . '<br \>' . json_encode(["mensaje" => $v1->messages(), "valores" => $this->_info_archivo]));
        } elseif ($v1->fails() && !empty($carga_archivo)) {
            return array('status' => 'error', 'detalle' => json_encode(["mensaje" => $v1->messages(), "valores" => $this->_info_archivo]));
        } elseif (!empty($carga_archivo)) {
            if ($detalle == 'S' && Header::where('trazadora', $this->_info_archivo['trazadora'])
              ->where('periodo', $this->_info_archivo['periodo'])
              ->where('detalle', 'N')
              ->first()) {
                return array('status' => 'ok', 'detalle' => json_encode($this->_info_archivo, JSON_PRETTY_PRINT));
            } elseif ($detalle == 'N') {
                return array('status' => 'ok', 'detalle' => json_encode($this->_info_archivo, JSON_PRETTY_PRINT));
            } else {
                return array('status' => 'error', 'detalle' => json_encode(["mensaje" => "No puede cargarse el archivo de detalle antes que el de la trazadora.", "valores" => $this->_info_archivo]));
            }
        }
    }

    /**
     * Limpia el nombre y apellido
     * @param string $data
     *
     * @return string
     */
    protected function sanitizeData($data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, ['observaciones','apellido','nombre'])) {
                $data[$key] = mb_convert_encoding($value, "UTF-8", mb_detect_encoding($value, "UTF-8, ISO-8859-1, ISO-8859-15", true));
            }
        }
        return $data;
    }

    /**
     * Guarda los datos del header a procesar en la base de datos.
     * @param array $header
     *
     * @return resource
     */
    public function procesarHeader($header)
    {
        $header = array_combine($this->_data_header, $header);
        $header['version_aplicativo'] = trim($header['version_aplicativo'], "\r\n");
        
        $v2 = Validator::make($header, $this->_header);
        if ($v2->fails()) {
            throw new Exception('El header del archivo no es correcto' . '<br \>' . json_encode($v2->messages()));
        }
        return $header;
    }

    public function procesarArchivo($id_subida)
    {
        
        $fh = $this->abrirArchivo($id_subida);
        
        if (!$fh) {
            return response()->json(['success' => 'false', 'errors'  => "El archivo no ha podido procesarse"]);
        }
                
        $lote = Lote::where('id_subida', $id_subida)->first()->lote;
   
        $nro_linea = 1;

        $header = preg_split("/[\t]/", fgets($fh));
             
        try {
            $ins_header = $this->procesarHeader($header);
                
            $new_header = new Header();
            $new_header->lote = $lote;
            $new_header->trazadora = $ins_header['trazadora'];
            $new_header->periodo = $this->_info_archivo['periodo'];
            $new_header->detalle = $this->_info_archivo['detalle'];
            $new_header->casos_positivos = $ins_header['casos_positivos'];
            $new_header->fecha_generacion = $ins_header['fecha_generacion'];
            $new_header->hora_generacion = $ins_header['hora_generacion'];
            $new_header->usuario_generacion = $ins_header['usuario_generacion'];
            $new_header->version_aplicativo = $ins_header['version_aplicativo'];
            $new_header->version_aplicativo = $ins_header['version_aplicativo'];
            $new_header->provincia = $this->_info_archivo['provincia'];
            $new_header->save();
            unset($new_header);
        } catch (Exception $e) {
            echo json_encode(['success' => 'false', 'errors' => $e->getMessage()]);
        }

        $info = Subida::findOrFail($id_subida);

        $this->_process_data["TRAZADORA_NUMBER"] = $this->_info_archivo['trazadora'];
        $this->_process_data["PERIOD"] = $this->_info_archivo['periodo'];
        $this->_process_data['FILE_PATH'] = $this->_process_data['FILE_DIR'] . $info->nombre_actual;
        $this->_process_data['LOGIC_FILE_NAME'] = 'trz_'.$this->_process_data['TRAZADORA_NUMBER'] . ($this->_info_archivo['detalle'] == 'S' ? '_det' : '') . '.load';
        $this->_process_data['TABLE_NAME'] = 'trz_'.$this->_process_data['TRAZADORA_NUMBER'] . ($this->_info_archivo['detalle'] == 'S' ? '_det' : '') . '_temp';
        $this->_process_data['NUMBER_LOTE'] = $lote;

        $unique_file = uniqid() . ".load";

        try {
            system("sudo cp " . $this->_process_data['LOGIC_DIR'] . $this->_process_data['LOGIC_FILE_NAME'] ." ". $this->_process_data['LOGIC_DIR'] . $unique_file);

            system("sed -i 's|:FILE_PATH|'".$this->_process_data['FILE_PATH']."'|g; s/:TABLE_NAME/".$this->_process_data['TABLE_NAME']."/g; s/:PERIOD/".$this->_process_data['PERIOD']."/g; s/:NUMBER_LOTE/".$this->_process_data['NUMBER_LOTE']."/g; s/:TRAZADORA_NUMBER/".$this->_process_data['TRAZADORA_NUMBER']."/g' " . $this->_process_data['LOGIC_DIR'] . $unique_file);

            $complete_result_file = $this->_process_data['LOGIC_DIR'] . $unique_file . '.result';

            //EJECUTO pgloader enviando los resultados a un archivo
            system("sudo pgloader " . $this->_process_data['LOGIC_DIR'] . $unique_file . ' > ' . $complete_result_file);

            //PASS errores to a variable
            exec('grep -A 1 "ERROR" ' . $complete_result_file, $errors);
            
            //Getting last line of result
            exec('tail -1 ' . $complete_result_file, $result);
            //Skipping mistakes in result
            $result = array_values($result);
            $result = array_pop($result);

            //Transforming line into an array
            preg_match("/(?:Total\ import\ time)(?:\ +)(\d+)(?:\ +)(\d+)(?:\ +)(\d+)(?:\ +)(\d+\.\d+s)/", $result, $procesado);
                        
            $this->_resumen['insertados'] = $procesado[2];
            $this->_resumen['rechazados'] = $procesado[3];
            system("sudo rm " . $this->_process_data['LOGIC_DIR'] . $unique_file);
            system("sudo rm " . $complete_result_file);
        } catch (Exception $e) {
            $this->_error['lote'] = $lote;
            $this->_error['created_at'] = date("Y-m-d H:i:s");
            $this->_error['registro'] = json_encode("PgLoader Error");
            $this->_error['motivos'] = json_encode($e->getMessage());
            Rechazo::insert($this->_error);
        }

        if (! empty($errors)) {
            $this->_error['lote'] = $lote;
            $this->_error['created_at'] = date("Y-m-d H:i:s");
            $this->_error['registro'] = json_encode("PgLoader Error");
            $this->_error['motivos'] = json_encode($errors);
            Rechazo::insert($this->_error);
        }
            
        $this->actualizaLote($lote, $this->_resumen);
        $this->actualizaSubida($id_subida);
        return response()->json(array('success' => 'true', 'data' => $this->_resumen));
    }
}
