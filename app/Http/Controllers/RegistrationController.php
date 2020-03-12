<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\SolicitudUsuarioRequest;
use App\Models\Area;
use App\Models\Usuario;

use Illuminate\Http\Request;
use Mail;

class RegistrationController extends Controller {
	/**
	 * Muestra el formulario de registro
	 *
	 * @return view
	 */
	public function index() {
		$data = [
			'areas' => Area::all()
		];

		return view('registration.main', $data);
	}

	/**
	 * Muestra el formulario de registro
	 * @param request Información del formulario
	 *
	 * @return view
	 */
	public function register(SolicitudUsuarioRequest $r) {
		$user                   = new Usuario;
		$user->nombre           = $r->nombre.' '.$r->apellido;
		$user->usuario          = $r->email;
		$user->email            = $r->email;
		$user->activo           = 'N';
		$user->id_provincia     = $r->provincia;
		$user->id_entidad       = $r->sede;
		$user->id_area          = $r->area;
		$user->id_menu          = 9;
		$user->ruta_imagen      = 'default-avatar.png';
		$user->fecha_nacimiento = $r->fecha_nacimiento;
		$user->cargo            = $r->cargo;
		$user->facebook         = $r->fb;
		$user->twitter          = $r->tw;
		$user->linkedin         = $r->ln;
		$user->google           = $r->gp;
		$user->skype            = $r->skype;
		$user->telefono         = $r->telefono;
		$user->password         = bcrypt(md5($r->pass));

		if ($user->save()) {
			Mail::send('emails.reminder', ['usuario' => $user], function ($m) use ($user) {
					$m->from('sirgeweb@sumar.com.ar', 'PACES');
					$m->to('sirgeweb@gmail.com');
					$m->to('javier.minsky@gmail.com');
				//	$m->to('aocariz@hotmail.com');
				//	$m->to('gavacca@msal.gov.ar');
				//	$m->to('rodrigo.cadaval.sumar@gmail.com');
					$m->subject('Solicitud de usuario!');
				});
			return view('registration.aviso');
		}
	}

	/**
	 * Método para el plugin jQuery Validator que busca si no existe un email
	 * @param request QueryString
	 *
	 * @return json
	 */
	public function email(Request $r) {
		$email  = $r->email;
		$existe = Usuario::where('email', '=', $email)->get();

		if (!count($existe)) {
			$json = true;
		} else {
			$json = false;
		}
		return json_encode($json);
	}

}
