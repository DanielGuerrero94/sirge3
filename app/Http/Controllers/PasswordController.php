<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Usuario;

class PasswordController extends Controller
{
    /**
     * Devuelve la vista principal
     *
     * @return view
     */
    public function index()
    {
    	return view('recovery.password');
    }

    /**
     * Envia el mail con la nueva contraseña
     * @param Request
     *
     * @return void
     */
    public function recover(Request $r)
    {
    	Usuario::where('email' , '=' , $r->email)->update(['password' => bcrypt('Homero')]);
    	$user = Usuario::where('email' , '=' , $r->email)->get();
    	Mail::send('emails.new_password', ['usuario' => $user[0]], function ($m) use ($user) {
            $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
            $m->to($user[0]->email, $user[0]->nombre);
            $m->subject('Cambio de contraseña');
        });
        return view('recovery.aviso');
    }

    /**
     * Verifica si el mail existe para recuperar la contraseña del usuario
     * @param Request
     *
     * @return json
     */
    public function email(Request $r)
    {
        $email = $r->email;
        $existe = Usuario::where('email' , '=' , $email)->get();

        if (count($existe)){
            $json = true;
        } else {
            $json = false;
        }
        return json_encode($json);
    }
}
