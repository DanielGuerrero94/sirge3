<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SolicitudUsuarioRequest extends Request
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
            'nombre' => 'required|min:3|max:60',
            'apellido' => 'required|min:3|max:60',
            'email' => 'required|email|unique:sistema.usuarios,email',
            'provincia' => 'required',
            'sede' => 'required',
            'fecha_nacimiento' => 'required|date_format:d/m/Y',
            'cargo' => 'required|max:50',
            'fb' => 'min:3|max:60',
            'tw' => 'min:3|max:60',
            'ln' => 'min:3|max:60',
            'gp' => 'min:3|max:60',
            'skype' => 'max:200',
            'telefono' => 'max:20',
            'pass' => 'required|min:6|max:60'
        ];
    }
}
