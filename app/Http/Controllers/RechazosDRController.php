<?php

namespace App\Http\Controllers;

use Excel;
use ZipArchive;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\RechazoDR;

class RechazosDRController extends Controller
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
     * Buscas los rechazos de datos reportables para el lote, arma un excel y un zip.
     * Deberia correrse en el mismo schedule que el excel de rechazos de prestaciones 
     * para que esten los dos disponibles al mismo tiempo
     * 
     * @return \Illuminate\Http\Response
     */
    public function createExcel($lote)
    {
        $rechazos = RechazoDR::select('registro','motivos')->where('lote',$lote)->get();

        if($rechazos->isEmpty()) return response()->json(['Estado' => 'Validado']);

        $data = ['rechazos' => $rechazos];

        Excel::create($lote , function ($e) use ($data){
            $e->sheet('Informe de datos reportables' , function ($s) use ($data){
                $s->setHeight(1, 20);
                $s->setColumnFormat([
                    'B' => '0',
                    'H' => '\PHPExcel_Style_NumberFormat::FORMAT_TEXT'
                    ]);          
                $s->loadView('padrones.excel-tabla.1_dr', $data);
            });
        })
        ->store('xlsx', storage_path('exports/rechazos_dr/'));

        $zip = new ZipArchive();
        $zip->open('/var/www/html/sirge3/storage/exports/rechazos_dr/'.$lote.'.zip', ZipArchive::CREATE);
        $zip->addFile('/var/www/html/sirge3/storage/exports/rechazos_dr/'.$lote.'.xlsx', $lote.'.xlsx');      
        $zip->close();      
        unlink('/var/www/html/sirge3/storage/exports/rechazos_dr/'.$lote.'.xlsx');

        return $this->descargarZip($lote);
    }

    /**
     * Decargar la tabla del lote
     * @lote integer
     * @return null
     */
    public function descargarZip($lote){      
      return response()->download('/var/www/html/sirge3/storage/exports/rechazos_dr/'.$lote.'.zip');
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
    public function show($lote)
    {
        $rechazos = Rechazo::select('registro' , 'motivos')->where('lote' , $lote)->get();

        if (! count($rechazos)){
          return response()->json(['mensaje' => 'El lote seleccionado fue eliminado o no posee rechazos']);
      }

      foreach ($rechazos as $key => $rechazo){
          $rechazos[$key]['registro'] = json_decode($rechazo['registro']);
          $rechazos[$key]['motivos'] = json_decode($rechazo['motivos']);
      }

      return response()->json($rechazos);
  }
}
