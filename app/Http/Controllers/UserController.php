<?php

namespace App\Http\Controllers;

use Datatables;
use Auth;
use Mail;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserEditProfileRequest;
use App\Http\Controllers\Controller;

use App\Models\Usuario;
use App\Models\Geo\Provincia;
use App\Models\Entidad;
use App\Models\Area;
use App\Models\Menu;

use App\Classes\Crop;

class UserController extends Controller
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
     * Devuelve el listado de usuarios registrados
     *
     * @return view
     */
    public function index(Request $r){
    	$data = [
    		'page_title' => 'ABM Usuarios'
    	];
		return view('admin.usuarios.usuarios' , $data);
    }

    /**
     * Devuelve el json para la datatable
     * 
     * @return json
     */
    public function tabla(){
        $usuarios = Usuario::with(['provincia','area','menu','entidad'])->get();

        for ($i=0; $i < count($usuarios); $i++) { 
            if( isset($usuarios[$i]->area)){
                $usuarios[$i]['nombre_area'] = $usuarios[$i]->area->nombre;    
            }
            else{
                $usuarios[$i]['nombre_area'] = '';       
            }            
        }
        //return print_r(json_encode($usuarios));
        return Datatables::of($usuarios)
            ->addColumn('action' , function($usuario){
                return '<button id-usuario="'. $usuario->id_usuario .'" class="edit-user btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button>';
            })
            ->setRowClass(function($usuario){
                return $usuario->activo == 'N' ? 'danger' : '';
            })
            ->make(true);
    }

    /**
     * Devuelve la vista para editar un usuario
     * @param int ID del usuario
     *
     * @return void
     */
    public function getEdit($id){
        $user = Usuario::find($id);
        $provincias = Provincia::all();
        $entidades = Entidad::all();
        $areas = Area::all();
        $menues = Menu::all();

        $data = [
            'usuario' => $user,
            'provincias' => $provincias,
            'entidades' => $entidades,
            'areas' => $areas,
            'menues' => $menues
        ];
        return view ('admin.usuarios.edit' , $data);
    }

    /**
     * Edita el usuario con los datos del formulario recibido
     * @param int ID del usuario
     * @param request Datos
     *
     * @return string
     */
    public function postEdit($id , Request $r){
        $usr = Usuario::find($id);
        $usr->nombre = $r->nombre;
        $usr->email = $r->email;
        $usr->id_provincia = $r->provincia;
        $usr->id_entidad = $r->entidad;
        $usr->id_menu = $r->menu;
        $usr->id_area = $r->area;
        if ($usr->save()){
            return 'Se ha modificado el usuario ' . $usr->nombre;
        }
    }

    /**
     * Acualiza el campo activo a "N" de un usuario por su ID
     * @param int ID del usuario
     *
     * @return string
     */
    public function postBaja($id){
        $u = Usuario::find($id);
        $u->activo = 'N';
        if ($u->save()){
            return 'Se ha bloqueado el acceso al usuario ' . $u->nombre;
        }
    }

    /**
     * Acualiza el campo activo a "S" de un usuario por su ID
     * @param int ID del usuario
     *
     * @return string
     */
    public function postUnblock($id){
        $u = Usuario::find($id);
        $u->activo = 'S';
        if ($u->save()){

            Mail::send('emails.alta', ['usuario' => $u], function ($m) use ($u) {
                $m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
                $m->to($u->email , $u->nombre);
                $m->to('gustavo.hekel@gmail.com', $u->nombre);
                $m->subject('Usuario habilitado');
            });

            return 'Se desbloqueado el acceso al usuario ' . $u->nombre;

        }
    }

    /**
     * Devuelve el perfil del usuario
     *
     * @return null
     */
    public function getProfile(){
        $id = Auth::user()->id_usuario;
        $user = Usuario::with(['provincia' , 'entidad' ,'area' , 'menu' , 'conexiones' => function($query){
            $query->orderBy('fecha_login' , 'desc')->take(5);
        }])->where('id_usuario' , $id)->get()[0];

        $data = [
            'page_title' => 'Perfil',
            'usuario' => $user
        ];
        return view('user.profile' , $data);
    }

    /**
     * Devuelve el formulario para editar el perfil del usuario
     *
     * @return null
     */
    public function getEditProfile(){
        $id = Auth::user()->id_usuario;
        $usuario = Usuario::find($id);
        $provincias = Provincia::all();
        $areas = Area::all();
        $entidades = Entidad::all();
        $data = [
            'page_title' => 'Editar perfil',
            'usuario' => $usuario,
            'provincias' => $provincias,
            'areas' => $areas,
            'entidades' => $entidades
        ];
        return view('user.edit' , $data);
    }

    /**
     * Actualiza los datos del usuario
     * @param Request Datos del formulario
     *
     * @return null
     */
    public function postEditProfile(UserEditProfileRequest $r){
        $id = Auth::user()->id_usuario;
        $email = Usuario::where('email' , $r->email)->where('id_usuario' , '<>' , $id)->get();
        if (! count($email)){
            
            $user = Usuario::find($id);
            $user->nombre = $r->nombre;
            $user->usuario = $r->email;
            $user->email = $r->email;
            $user->id_provincia = $r->provincia;
            $user->id_entidad = $r->entidad;
            $user->id_area = $r->area;
            $user->fecha_nacimiento = $r->fecha_nacimiento;
            $user->ocupacion = $r->ocupacion;
            $user->facebook = $r->fb;
            $user->twitter = $r->tw;
            $user->linkedin = $r->ln;
            $user->google = $r->gp;
            $user->skype = $r->skype;
            $user->telefono = $r->telefono;
            $user->mensaje = $r->mensaje;
            if ($user->save()){
                return 1;
            }
        } else {
            return response('Error' , 422);
        }
    }

    /**
     * Devuelve la vista para cambiar la contraseña
     *
     * @return null
     */
    public function getNewPassword(){
        return view('user.password');
    }

    /**
     * Cambia la password desde el perfil del usuario
     *
     * @return string
     */
    public function postNewPassword(Request $r){
        $this->validate($r, [
            'pass' => 'required|min:6',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($r->pass);
        if ($user->save()){
            return 'Se ha modificado la contraseña';
        }
    }

    /**
     * Devuelve la vista para cambiar la imagen de perfil
     *
     * @return null
     */
    public function getAvatar(){

        $data = [
            'page_title' => 'Cambiar imágen de perfil',
            'user' => Auth::user()
        ];
        return view('user.avatar' , $data);
    }

    /**
     * Recibe la imagen
     * @param Request $r
     *
     * @return null
     */
    public function postAvatar(Request $r){
        $crop = new Crop(
            ($r->file('avatar_src') !== null) ? $r->file('avatar_src') : null,
            $r->avatar_data,
            ($r->file('avatar_file') !== null) ? $r->file('avatar_file') : null
        );

        $response = array(
          'state'  => 200,
          'message' => $crop -> getMsg(),
          'result' => $crop -> getNewRoute()
        );

        $u = Auth::user();
        $u->ruta_imagen = $crop -> getNewFile();
        $u->save();

        return response()->json($response);
    }
}

