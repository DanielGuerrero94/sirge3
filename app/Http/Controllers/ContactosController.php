<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Geo\Provincia;
use App\Models\Conversacion;
use App\Models\Mensaje;

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

    /**
     * Crea la vista principal del módulo de Contactos
     * @return view
     */
    public function index(){
        $data = [
            'page_title' => 'Contactos SUMAR',
            'contactos' => Usuario::with('provincia')->orderBy('id_usuario')->get()
        ];
    	return view('contactos.main' , $data);
    }

    /**
     * Crea el listado de usuarios registrados y maneja la búsqueda
     * @param string Nombre de usuario a buscar
     *
     * @return view
     */
    public function listado($nombre) {
        
        if ($nombre == 'ALL'){
            $contactos = Usuario::with('provincia')->where('activo','S')->orderBy('id_usuario')->get();  
        } else {
            $contactos = Usuario::with('provincia')->where('activo','S')->where('nombre' , 'ilike' , "%{$nombre}%")->orderBy('id_usuario')->get();
        }

        $data = ['contactos' => $contactos];
        return view('contactos.listado' , $data);
    }

    /**
     * Genera la tarjeta de información del usuario seleccionado
     * @param int Id del usuario buscado
     *
     * @return view
     */
    public function tarjeta($id){
        $data = ['usuario' => Usuario::with('provincia')->get()->find($id)];
        return view('contactos.tarjeta' , $data);
    }

    /**
     * Levanto el chat entre usuarios
     * @param int $id_from usuario que envia el mensaje
     * @param int $id_to usuario que recibe el mensaje
     *
     * @return view
     */
    public function chat($id_from , $id_to){
        
        $c = DB::select("select * from chat.conversaciones where usuarios @> '{{$id_from},{$id_to}}'");

        if (! sizeof($c)){
            $chat = new Conversacion;
            $chat->usuarios = "{{$id_from},{$id_to}}";
            $chat->save();
            $id_conversacion = $chat->id;
        } else {
            $id_conversacion = $c[0]->id;
        }

        $mensajes = Conversacion::with([
            'mensajes' => function ($query){$query->orderBy('fecha','desc');}, 
            'mensajes.usuario' => function($query){}
        ])->where('id' , '=' , $id_conversacion)->get();

        $data = [
            'info' => $mensajes
        ];
        return view('contactos.mensajes' , $data);
    }

    /**
     * Levanta una conversacion por su id
     * @param int $id Id de la conversacion
     * 
     * @return view
     */
    private function getChat ($id){
        
        $mensajes = Conversacion::with([
            'mensajes' => function ($query){$query->orderBy('fecha','desc');}, 
            'mensajes.usuario' => function($query){}
        ])->where('id', '=' , $id)->get();
        
        $data = [
            'info' => $mensajes
        ];

        return view('contactos.mensajes' , $data);
    }

    /**
     * Guarda el mensaje nuevo
     * @param request Formulario del mensaje
     *
     * @return view
     */
    public function nuevoMensaje (Request $request){
        $m = new Mensaje;
        $m->id_conversacion = $request->id_conversacion;
        $m->id_usuario = Auth::user()->id_usuario;
        $m->mensaje = $request->message;
        $m->save();

        return $this->getChat($request->id_conversacion);
    }
}
