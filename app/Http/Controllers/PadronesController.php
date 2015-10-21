<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use ErrorException;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;
use App\Models\Lote;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PadronesController extends Controller
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
	 * Devuelve la vista principal
	 * @param string $padron
	 * @param int $id
	 * 
	 * @return null
	 */
	public function getMain($id){

		$archivos_pendientes = Subida::where('id_estado' , 1)->where('id_padron' , $id)->count();
		
		$lotes_pendientes = Lote::join('sistema.subidas' , 'sistema.lotes.id_subida' , '=' , 'sistema.subidas.id_subida')
							->where('id_padron' , $id)
							->where('sistema.lotes.id_estado' , 1);

		if (Auth::user()->id_entidad == 2) {
			$lotes_pendientes = $lotes_pendientes->where('id_provincia' , Auth::user()->id_provincia)->count();
		} else {
			$lotes_pendientes = $lotes_pendientes->count();
		}

		// return $lotes_pendientes;

		$data = [
			'page_title' => $this->getName($id),
			'id_padron' => $id,
			'archivos_pendientes' => $archivos_pendientes,
			'lotes_pendientes' => $lotes_pendientes
		];
		return view('padrones.main' , $data);
	}

	/**
	 * Devuelve la ruta donde guardar el archivo
	 * @param int $id
	 *
	 * @return string
	 */
	protected function getName($id , $route = FALSE){
		switch ($id) {
			case 1:
				$p = 'prestaciones'; break;
			case 2 :
				$p = 'fondos'; break;
			case 3 :
				$p = 'comprobantes'; break;
			case 4 : 
				$p = 'osp'; break;
			case 5 :
				$p = 'profe'; break;
			case 6 :
				$p = 'sss'; break;
			default:
				break;
		}
		if ($route)
			return '../storage/uploads/' . $p;
		else
			return ucwords($p);
	}

	/** 
	 * Devuelve la vista para subir un padrón
	 * @param int $id
	 *
	 * @return null
	 */
	public function getUpload($id){
		$data = [
			'page_title' => 'Subir archivos',
			'id_padron' => $id
		];
		return view('padrones.upload-files' , $data);
	}

	/**
	 * Guarda el archivo en el sistema
	 * @param $r Request
	 *
	 * @return json
	 */
	public function postUpload(Request $r){
		$nombre_archivo = uniqid() . '.txt';
		$destino = $this->getName($r->id_padron , TRUE);
		$s = new Subida;

		$s->id_usuario = Auth::user()->id_usuario;
		$s->id_padron = $r->id_padron;
		$s->nombre_original = $r->file->getClientOriginalName();
		$s->nombre_actual = $nombre_archivo;
		$s->size = $r->file->getClientSize();
		$s->id_estado = 1;

		try {
			$r->file('file')->move($destino , $nombre_archivo);
		} catch (FileException $e){
			return response("Ha ocurrido un error" , 422);
		}
		if ($s->save()){
			return response()->json(['file' => $r->file->getClientOriginalName()]); 
		}
	}

	/**
	 * Devuelve la vista para procesar archivos
	 *
	 * @return null
	 */
	public function listadoArchivos($id){
		$data = [
			'page_title' => 'Archivos subidos',
			'id_padron' => $id,
			'ruta_procesar' => 'procesar-' . strtolower($this->getName($id))
		];
		return view('padrones.process-files' , $data);
	}


	/**
	 * Devuelve el listado de archivos subidos
	 * @param int $id_padron
	 *
	 * @return json
	 */
	public function listadoArchivosTabla($id_padron){
		$archivos = Subida::where('id_padron' , $id_padron)
					->where('id_estado' , 1)
					->where('id_usuario' , Auth::user()->id_usuario)
					->get();
		return Datatables::of($archivos)
			->addColumn('action' , function($archivo){
              return '
              	<button id-subida="'. $archivo->id_subida .'" class="procesar btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Procesar</button>
              	<button id-subida="'. $archivo->id_subida .'" class="eliminar btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i> Eliminar</button>';
          	})
			->make(true);
	}

	/**
	 * Elimina un archivo
	 * @param int $id
	 *
	 * @return json
	 */
	public function eliminarArchivo($id){
		$f = Subida::find($id);
		$f->id_estado = 4;
		if ($f->save()){
			try {
				unlink ($this->getName($f->id_padron , TRUE) . '/' . $f->nombre_actual);
				return 'Se ha eliminado el archivo';
			} catch (ErrorException $e) {
				return 'Se ha eliminado el archivo';
			}
		}
	}
}
