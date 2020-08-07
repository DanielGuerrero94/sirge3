<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Storage;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function curlCall($url) {
          
        \Log::info($url);

        $user = Auth::user();

    	$ch = curl_init(env("API_URL").$url);

    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Authorization: '.$user->token,
        ));

        $response = curl_exec($ch);

        if(curl_error($ch)) {
            \Log::error(curl_error($ch));
	        return response()->json(['mensaje' => curl_error($ch)], 400);
        }

        curl_close($ch);

    	return $response;
    }

    public function postCall($url, $id_provincia, $filename) {

        $user = Auth::user();

    	$ch = curl_init(env("API_URL").$url);

    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, 
		"periodo=2020-06&id_provincia=".$id_provincia."&filename=".$filename);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Authorization: '.$user->token,
        ));

        $response = curl_exec($ch);

        if(curl_error($ch)) {
            \Log::error(curl_error($ch));
	        return response()->json(['mensaje' => curl_error($ch)], 400);
        }

        curl_close($ch);

    	return $response;
    }

    /**
     * Busca el modulo en sirge-web.
     *
     * @return view
     */
    public function getAnalisis($id)
    {
	    return $this->curlCall("analisis/".$id);
    }

    /**
     * Devuelve el csv del diccionario de datos de prestaciones de sirge-web.
     *
     * @return file:csv
     */
    public function getDiccionarioExport()
    {
	$filename = 'diccionario-prestaciones-'.Carbon::now().'.csv';
	$fp = fopen($filename, 'w+');

	if($fp === false){
	    throw new Exception('No se pudo crear: ' . $filename);
	}

	$ch = curl_init(env("API_URL")."diccionarios/export");

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $response = curl_exec($ch);
	$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if(curl_error($ch)) {
            \Log::error(curl_error($ch));
	    return response()->json(['status' => $statusCode, 'error' => curl_error($ch)]);
        }
        curl_close($ch);
	fclose($fp);
	return response()->download($filename);
    }

    public function postCsv(Request $request)
    {
        $id = Auth::user()->id_usuario;

	$id_provincia = Auth::user()->id_provincia;

	if ($request->has('id_provincia')) {
	  $id_provincia = $request->id_provincia;	
	} 

        try {
	    \Log::info($_FILES);
	    $file = $request->file('file');
	    $filename = $file->getClientOriginalName();
	    $file->move(storage_path('app'), $filename);

            $new = $id.'_'.$filename;

	    $path = storage_path('app/').$filename;

	    $content = file_get_contents($path);
        } catch (\FileException $e) {
	    \Log::error($e->getMessage());
            return response()->json(['success' => 'false', 'errors' => "Ha ocurrido un error: ".$e->getMessage()]);
        }

	Storage::disk('sirge-web')->put($new, $content);
	$response = $this->postCall('importaciones', $id_provincia, $new);

	\Log::info($response);

	return 'OK';
    }

    public function getImportacionErrores($id)
    {
        return $this->curlCall("importaciones/".$id."/errores");
    }

    public function getImportacionValidaciones($id)
    {
        return $this->curlCall("importaciones/".$id."/validaciones");
    }


}
