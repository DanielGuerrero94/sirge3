<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InboxController extends Controller{
    
	/**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

	/**
	 * Levanto todas las conversaciones activas del usuario
	 * 
	 * @return view
	 */
    public function index(){
    	$user = Auth::user()->id_usuario;
    	$usuarios = DB::select("
		select u.*
		from (
			select 
				unnest(usuarios) as usuarios 
			from chat.conversaciones 
			where usuarios @> '{{$user}}'
			) a  left join 
			sistema.usuarios u on a.usuarios = u.id_usuario
		where usuarios <> $user");

    	$data = [
    		'page_title' => 'Conversaciones activas',
    		'usuarios' => $usuarios
		];
    	return view('inbox.main' , $data);

    }
}
