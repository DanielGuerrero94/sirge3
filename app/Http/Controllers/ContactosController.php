<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Usuario;
use App\Classes\Provincia;
use App\Classes\Conversacion;
use App\Classes\Mensaje;

class ContactosController extends Controller
{
	/**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
        $data = [
            'page_title' => 'Contactos SUMAR',
            'contactos' => Usuario::with(['provincia' , 'conexion'])->orderBy('id_usuario')->get()
        ];
    	return view('contactos.main' , $data);
    }

    public function listado($nombre) {
        
        if ($nombre == 'ALL'){
            $contactos = Usuario::with(['provincia' , 'conexion'])->orderBy('id_usuario')->get();  
        } else {
            $contactos = Usuario::with(['provincia' , 'conexion'])->where('nombre' , 'ilike' , "%{$nombre}%")->orderBy('id_usuario')->get();
        }

        $data = ['contactos' => $contactos];
        return view('contactos.listado' , $data);
    }

    public function tarjeta($id){
        $data = ['usuario' => Usuario::with('provincia')->get()->find($id)];
        return view('contactos.tarjeta' , $data);
    }

    public function chat($id_from , $id_to){
        
        $c = DB::select("select * from chat.conversaciones where usuarios @> '{ {$id_from},{$id_to} }'");

        if (! sizeof($c)){
            // Creo un nuevo chat
            $chat = new Conversacion;
            $chat->usuarios = "{{$id_from},{$id_to}}";
            $chat->save();
        }

        $mensajes = Conversacion::with([
            'mensajes' => function ($query){$query->orderBy('fecha','desc');}, 
            'mensajes.usuario' => function($query){}
        ])->where('usuarios' , '=' , "{{$id_from},{$id_to}}")->get();

        $data = [
            'info' => $mensajes
        ];

        return view('contactos.mensajes' , $data);
        //echo '<pre>' , $mensajes , '</pre>';
    }

    private function getChat ($id){
         $mensajes = Conversacion::find($id)->with([
            'mensajes' => function ($query){$query->orderBy('fecha','desc');}, 
            'mensajes.usuario' => function($query){}
        ])->get();

        return view('contactos.mensajes' , $mensajes[0]);
    }

    public function nuevoMensaje (Request $request){
        $m = new Mensaje;
        $m->id_conversacion = $request->id_conversacion;
        $m->id_usuario = Auth::user()->id_usuario;
        $m->mensaje = $request->message;
        $m->save();

        return $this->getChat($request->id_conversacion);
    }
}
