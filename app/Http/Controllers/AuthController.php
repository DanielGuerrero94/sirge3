<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Classes\Login;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password , 'activo' => 'S'])) {
            // Authentication passed...
        	
        	$login = new Login;
        	$login->id_usuario = Auth::user()->id_usuario;
        	$login->ip = $_SERVER['REMOTE_ADDR'];
        	$login->save();

            return redirect()->intended('inicio');
        } else {
        	// Authentication failed...
        	$data = [
        		'errors' => [
        			'Falló la autenticación'
        		]
        	];
        	return redirect('login')->with($data);
        }
    }
}
