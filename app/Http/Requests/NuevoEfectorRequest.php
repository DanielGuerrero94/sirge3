<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NuevoEfectorRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

/*
legal:
dep_adm:
dep_san:
cics:
rural:
categoria:
integrante:
priorizado:
compromiso:
direccion:
provincia:
departamento:
localidad:
codigo_postal:
ciudad:
numero_compromiso:
firmante_compromiso:
indirecto:
compromiso_fsus:
compromiso_fini:
compromiso_ffin:
convenio_numero:
convenio_firmante:
convenio_fsus:
convenio_fini:
convenio_ffin:
cuie_admin:
nombre_admin:
tel:
obs_tel:
correo:
refer:
*/
        return [
            'cuie' => 'required|between:6,6',
            'siisa' => 'required|digits:14',
            'tipo' => 'required',
            'nombre' => 'required|between:10,200',

        ];
    }
}
