<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class UserEditProfileRequest extends Request
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
            'email' => 'required|email',
            'provincia' => 'required',
            'entidad' => 'required',
            'fecha_nacimiento' => 'required|date_format:d/m/Y',
            'ocupacion' => 'required|max:30',
            'fb' => 'url',
            'tw' => 'url',
            'ln' => 'url',
            'gp' => 'url',
            'skype' => 'max:200',
            'telefono' => 'max:20',
        ];
    }
}
