<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Mail;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Usuario;
use App\Http\Requests\SolicitudUsuarioRequest;

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
    public function register(SolicitudUsuarioRequest $r)
    {
    	$user = new Usuario;
        $user->nombre = $r->nombre . ' ' . $r->apellido;
        $user->usuario = $r->email;
        $user->email = $r->email;
        $user->activo = 'N';
        $user->id_provincia = $r->provincia;
        $user->id_entidad = $r->sede;
        $user->id_area = $r->area;
        $user->id_menu = 1;
        $user->fecha_nacimiento = $r->fecha_nacimiento;
        $user->ocupacion = $r->ocupacion;
        $user->facebook = $r->fb;
        $user->twitter = $r->tw;
        $user->linkedin = $r->ln;
        $user->google = $r->gp;
        $user->skype = $r->skype;
        $user->telefono = $r->telefono;
        $user->password = bcrypt($r->pass);
        
        if ($user->save()){
            Mail::send('emails.reminder', ['usuario' => $user], function ($m) use ($user) {
                $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
                $m->to('sistemasuec@gmail.com', $user->nombre);
                $m->subject('Solicitud de usuario!');
            });
            return view('registration.aviso');
        }
    }

    /**
     * Método para el plugin jQuery Validator que busca si existe un email
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
