<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Telesalud\Telesalud;
use App\Models\Geo\Provincia;

use Auth;
use Hash;
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

        $json = json_decode('{"id":"75159","nombre":"Nora Analía del Valle","apellido":"Vizgarra","username":"24808157","password":"$2a$10$QIV.ZCOsAjsKQrh1S4nRJeXrlPf3NAxRD2di9pndXcwIpi5XVf93y","centro_id":"1271","enabled":"1","especialidad_id":"","matricula":"1993","domicilio":"Victor Alcorta 5020","telefono":"","mail":"noriviz@yahoo.com.ar","matricula_provincial":"1993","tipo_documento":"DNI","numero_documento":"24808157","primer_ingreso":"0","centro":"Hospital Zonal Dr. Cazzaniga - Fernandez"}', true);

		$data = [
			'page_title' => 'Telesalud',
            'user' => $user,
            'json' => $json
		];
		return view('telesalud.main' , $data);
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

        $data = json_decode('{"id":"75159","nombre":"Nora Analía del Valle","apellido":"Vizgarra","username":"24808157","password":"123456","centro_id":"1271","enabled":"1","especialidad_id":"","matricula":"1993","domicilio":"Victor Alcorta 5020","telefono":"","mail":"noriviz@yahoo.com.ar","matricula_provincial":"1993","tipo_documento":"DNI","numero_documento":"24808157","primer_ingreso":"0","centro":"Hospital Zonal Dr. Cazzaniga - Fernandez"}', true);
        return Usuario::create([
            'usuario' => $data['mail'],
            'nombre' => $data['nombre'] . ' ' . $data['apellido'],
            'email' => $data['mail'],
            'activo' => "S",
            'id_provincia' => "14",
            'id_entidad' => "3",
            'id_menu' => "22",
            'password' => bcrypt($data['password'])
        ]);

	}

	/**
     * Devuelve el csv con los datos
     * 
	 * @return null
	 */
    public function descarga(){
		return response()->download('../storage/telesalud/consultas.xls');
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
