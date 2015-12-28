<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DOIU9Request extends Request
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
            'periodo_tablero' => 'required|date_format:Y-m',
            'fecha_cuenta_capitas' => 'required|date_format:d/m/Y',
            'periodo_cuenta_capitas' => 'required|date_format:Y-m',
            'fecha_sirge' => 'required|date_format:d/m/Y',
            'periodo_sirge' => 'required|date_format:Y-m',
            'fecha_reporte_bimestral' => 'required|date_format:d/m/Y',
            'bimestre' => 'required' ,
            'anio_bimestre' => 'required'
        ];
    }
}
