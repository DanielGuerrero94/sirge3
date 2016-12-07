<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Login;
use App\Models\Usuario;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => md5($request->password)])) {
		if(Auth::user()->activo == 'S' || Auth::user()->id_usuario == 1) {
	            	// Authentication passed...
        		if (Auth::user()->id_usuario <> 1) {
				$login = new Login;
        			$login->id_usuario = Auth::user()->id_usuario;
        			$login->ip = $_SERVER['REMOTE_ADDR'];
        			$login->save();

				$user = Usuario::find(Auth::user()->id_usuario);
				$user->last_login = date("Y-m-d H:i:s");
				$user->save();                
                $_SESSION['recent_post'] = false;
                $_SESSION['recent_post_time'] = time();                
			}
			return redirect()->intended('inicio');
		}
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
