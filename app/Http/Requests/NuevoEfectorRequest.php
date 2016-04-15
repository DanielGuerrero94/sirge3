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
        return [
            'cuie' => 'required|between:6,6',
            'siisa' => 'required|digits:14',
            'tipo' => 'required',
            'nombre' => 'required|between:10,200',
            'dep_adm' => 'required',
            'cics' => 'required',
            'rural' => 'required',
            'categoria' => 'required',
            'integrante' => 'required',
            'priorizado' => 'required',
            'compromiso' => 'required',
            'direccion' => 'required|between:5,500',
            'provincia' => 'required',
            'departamento' => 'required',
            'localidad' => 'required',
            'numero_compromiso' => 'required_if:compromiso,S|min:3',
            'firmante_compromiso' => 'required_if:compromiso,S|min:8',
            'compromiso_fsus' => 'required_if:compromiso,S|date_format:Y-m-d',
            'compromiso_fini' => 'required_if:compromiso,S|date_format:Y-m-d',
            'compromiso_ffin' => 'required_if:compromiso,S|date_format:Y-m-d',
            'indirecto' => 'required_if:compromiso,S',
            'convenio_numero' => 'required_if:indirecto,S|min:3',
            'convenio_firmante' => 'required_if:indirecto,S|min:3',
            'convenio_fsus' => 'required_if:indirecto,S|date_format:Y-m-d',
            'convenio_fini' => 'required_if:indirecto,S|date_format:Y-m-d',
            'convenio_ffin' => 'required_if:indirecto,S|date_format:Y-m-d',
            'correo' => 'email',
            'refer' => 'between:8,200'
        ];
    }
}
