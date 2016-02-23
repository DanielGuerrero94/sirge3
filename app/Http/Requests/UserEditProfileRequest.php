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
            'cargo' => 'max:50',
            'fb' => 'min:3|max:60',
            'tw' => 'min:3|max:60',
            'ln' => 'min:3|max:60',
            'gp' => 'min:3|max:60',
            'skype' => 'max:200',
            'telefono' => 'max:20',
        ];
    }
}
