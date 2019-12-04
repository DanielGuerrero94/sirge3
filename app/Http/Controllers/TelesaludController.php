<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Telesalud\Telesalud;
use App\Models\Telesalud\UsuarioTelesalud;
use App\Models\Telesalud\CentroTelesalud;
use App\Models\Telesalud\Sirge;
use App\Models\Geo\Provincia;

use Auth;
use Hash;
use Excel;
use App\Models\Usuario;

class TelesaludController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

	/**
	 * Devuelve la vista principal
	 *
	 * @return null
	 */
	public function mainForm(){

        $user = Auth::user();
     
        $usuario = Sirge::where('id_sirge', $user->id_usuario)->first();

        if($usuario != null) {
		$data = [
			'page_title' => 'Telesalud',
            'json' => $usuario
		];
        return view('telesalud.main' , $data);
        }

        $ids = Sirge::select('id_sirge')->get()
        ->map(function ($v){
            return $v->id_sirge;
        })->toArray();
        $usuarios = Usuario::select('usuario')
        ->whereIn('id_usuario', $ids)->get()->toJson();

        return response()->json($usuarios);
	}

	/**
	 * Devuelve la consulta para el usuario que este logueado
	 *
	 * @return null
	 */
	public function consulta(){

		$provincias = Provincia::all();

		$data = [
			'page_title' => 'Telesalud',
			'provincias' => $provincias
		];
		return view('telesalud.main' , $data);
	}

	/**
	 * Devuelve los datos del usuario en el caso que sea parte del rol telesalud
	 *
	 * @return null
	 */
	public function usuario(){

        $usuarios = json_decode('{"telesalud":[{"mail":"mocd333@gmail.com","nombre":"Maria del Carmen","apellido":"Cuello","id_provincia":"07"}]}', true);

        $usuarios = $usuarios['telesalud'];

        foreach($usuarios as $data) {


        $nuevo =  Usuario::create([
            'usuario' => $data['mail'],
            'nombre' => $data['nombre'] . ' ' . $data['apellido'],
            'email' => $data['mail'],
            'activo' => "S",
            'id_provincia' => $data['id_provincia'],
            'id_entidad' => "3",
            'id_menu' => "22",
            'password' => bcrypt('Tele$alud2019')
        ]);
            \Log::info($nuevo);
        }
	}

	/**
     * Devuelve el csv con los datos
     * 
	 * @return null
	 */
    public function descarga(){
        $user = Auth::user();
     
        $usuario = Sirge::where('id_sirge', $user->id_usuario)->first();

        $id = $usuario->id;

        $consulta = Telesalud::where('creador_id', $id)->get();
		$data = [
			'resultados'    => $consulta
		];

        \Log::info($data);

		Excel::create(
			'telesalud-'.$id,
			function ($excel) use ($data) {
				$excel->sheet(
					'Telesalud',
					function ($sheet) use ($data) {
						$sheet->setHeight(1, 20);
						$sheet->setColumnFormat(
							[
								'A' => '@'
							]
						);
						$sheet->loadView('telesalud.excel-template', $data);
					}
				);
			}
		)->store('xls');

		return response()->download('../storage/exports/telesalud-'.$id.'.xls');
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
