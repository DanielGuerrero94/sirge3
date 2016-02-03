<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Reporte;
use App\Models\Geo\Provincia;
use App\Models\Dw\CEB\Ceb001;
use App\Models\Dw\FC\Fc001;
use App\Models\Dw\FC\Fc002;
use App\Models\Dw\FC\Fc004;
use App\Models\Dw\FC\Fc005;
use App\Models\Dw\FC\Fc006;
use App\Models\Dw\FC\Fc007;
use App\Models\Dw\FC\Fc008;
use App\Models\Dw\FC\Fc009;
use App\Models\PSS\DatoReportable;

class ReportesController extends Controller
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
     * Aclara el color base
     * @param int
     *
     * @return string
     */
    protected function alter_brightness($colourstr, $steps) {
        $colourstr = str_replace('#','',$colourstr);
        $rhex = substr($colourstr,0,2);
        $ghex = substr($colourstr,2,2);
        $bhex = substr($colourstr,4,2);

        $r = hexdec($rhex);
        $g = hexdec($ghex);
        $b = hexdec($bhex);

        $r = max(0,min(255,$r + $steps));
        $g = max(0,min(255,$g + $steps));  
        $b = max(0,min(255,$b + $steps));

        return '#'.str_pad(dechex($r) , 2 , '0' , STR_PAD_LEFT).str_pad(dechex($g) , 2 , '0' , STR_PAD_LEFT).str_pad(dechex($b) , 2 , '0' , STR_PAD_LEFT);
    }
	

    /**
     * Devuelve la info para el reporte 1
     *
     * @return json
     */
    public function getReporte1(){
        $data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');
        
        foreach ($data['categorias'] as $key => $provincia){
            $data['categorias'][$key] = ucwords(mb_strtolower($provincia));
        }

        $prestaciones = Fc001::select('id_provincia' , DB::raw('sum(cantidad) as c'))
                            ->groupBy('id_provincia')
                            ->orderBy('id_provincia')
                            ->get();
        foreach ($prestaciones as $key => $prestacion) {
            $data['series'][0]['name'] = 'Prestaciones facturadas';
            $data['series'][0]['data'][] = $prestacion->c;
        }

        return response()->json($data);
    }

    /**
     * Devuelve JSON para la datatable
     *
     * @return json
     */
    public function getReporte1Tabla(){
        $prestaciones = Fc001::join('geo.provincias as p' , 'estadisticas.fc_001.id_provincia' , '=' , 'p.id_provincia');
        return Datatables::of($prestaciones)->make(true);
    }
}
