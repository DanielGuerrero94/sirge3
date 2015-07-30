<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Usuario;

class RegistrationController extends Controller
{
    /**
     * Muestra el formulario de registro
     *
     * @return view
     */
    public function index()
    {
    	return view('registration.main');
    }

    /**
     * Muestra el formulario de registro
     * @param request Información del formulario
     * 
     * @return view
     */
    public function register(Request $r)
    {
        $this->validate($r , [
            
        ]);
        /*
    	$user = new Usuario;
        $user->nombre = $r->nombre . ' ' . $r->apellido;
        $user->email = $r->email;
        $user->activo = 'N';
        $user->id_provincia = $r->provincia;
        $user->id_entidad = $r->entidad;
        $user->area = $r->area;
        $user->fecha_nacimiento = $r->fecha_nacimiento;
        $user->ocupacion = $r->ocupacion;
        $user->facebook = $r->fb;
        $user->twitter = $r->tw;
        $user->linkedin = $r->ln;
        $user->google = $r->gp;
        $user->skype = $r->skype;
        $user->telefono = $r->telefono;
        $user->save();
        */

    }

    /**
     * Método para el plugin jQuery Validator
     * @param request QueryString
     *
     * @return json
     */
    public function email(Request $r)
    {
        $email = $r->email;
        $existe = Usuario::where('email' , '=' , $email)->get();

        if (! count($existe)){
            $json = true;
        } else {
            $json = false;
        }

        return json_encode($json);
    }


}
