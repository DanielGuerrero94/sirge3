<?php

namespace App\Http\Controllers\Indicadores;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Beneficiario;
use App\Models\Beneficiarios\Ceb;
use App\Models\Beneficiarios\Periodos;
use App\Models\Efector;
use App\Models\Efectores\Geografico;
use App\Models\Geo\Provincia;
use App\Models\Prestacion;

use DB;

class PriorizadosController extends Controller
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

    /**
     * Realiza la query secuencial de indicadores
     *
     * @param  int  $id_provincia
     * @param  int  $periodo     
     * @return \Illuminate\Http\Response
     */
    public function indicadoresPriorizados($id_provincia,$periodo)
    {
             
    }

    /**
     * Realiza la query para el indicador 1.1
     * Beneficiarios asignados al efector con cobertura efectiva básica.
     * @param  int  $id_provincia
     * @param  int  $periodo     
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_1_1($id_provincia,$anio)
    {
        $periodo = $anio . '01';

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })
                             ->join('beneficiarios.ceb', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.ceb.clave_beneficiario','=','beneficiarios.periodos.clave_beneficiario')
                                         ->where('beneficiarios.ceb.periodo','=',$periodo);
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)                                                             
                            ->select('cuie', DB::raw($periodo),DB::raw('1.1'),DB::raw($id_provincia), DB::raw('sum(case ceb
                                                                                    when \'S\' then 1
                                                                                    else 0 end) as res_ceb'), DB::raw('count(*) as total'))                            

                            ->groupBy('cuie')
                            ->get();

        return json_encode($indicadorToInsert);
    }                            
    

    /**
     * Realiza la query para el indicador 1.2
     * Beneficiarios de 6 a 9 años asignados al efector con cobertura efectiva básica.
     * @param  int  $id_provincia
     * @param  int  $periodo
     * @param  int  $indicador
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_1_2($id_provincia,$anio,$fecha = null)
    {
        $periodo = $anio . '01';

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')                             
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })
                             ->join('beneficiarios.ceb', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.ceb.clave_beneficiario','=','beneficiarios.periodos.clave_beneficiario')
                                         ->where('beneficiarios.ceb.periodo','=',$periodo);
                                })
                             ->join('beneficiarios.beneficiarios', function($join) use ($fecha)
                                {
                                    $join->on('beneficiarios.ceb.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'6 years\''),'>=',$fecha)
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'9 years\''),'<=',$fecha);
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('beneficiarios.beneficiarios_periodos.activo','=','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)                            
                            ->select('cuie', DB::raw($periodo),DB::raw('1.2'),DB::raw($id_provincia), DB::raw('sum(case ceb
                                                                                    when \'S\' then 1
                                                                                    else 0 end) as res_ceb'), DB::raw('count(*) as total'))                            

                            ->groupBy('cuie')
                            ->get();

           return json_encode($indicadorToInsert);

   }

    /**
     * Realiza la query para el indicador 3.3 "numerador"
     * Adolescentes de 10-19 a cargo del efector con consulta odontológica fact y aprob por la SPS (CT C010 A97).
     * @param  int  $id_provincia
     * @param  int  $periodo     
     * @param  int  $fecha
     * @param  int  $fecha_inicio_cuatri
     * @param  int  $fecha_fin_cuatri
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_3_3_numerador($id_provincia,$anio,$fecha = null,$fecha_inicio_cuatri = null,$fecha_fin_cuatri = null)
    {
        $periodo = $anio . '04';
        $fecha_inicio_cuatri = '2015-01-01';
        $fecha_fin_cuatri = '2015-04-30';
        $fecha = '2015-04-30';

        DB::connection()->enableQueryLog();

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')                             
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })
                             ->join('beneficiarios.beneficiarios', function($join) use ($fecha)
                                {
                                    $join->on('beneficiarios.periodos.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'10 years\''),'>=',$fecha)
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'19 years\''),'<=',$fecha);
                                })
                             ->join('prestaciones.prestaciones', function($join) use ($fecha_inicio_cuatri,$fecha_fin_cuatri)
                                {
                                    $join->on('prestaciones.prestaciones.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->on('prestaciones.prestaciones.efector','=','efectores.efectores.cuie');                                         
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('beneficiarios.periodos.activo','=','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)                            
                            ->where('prestaciones.prestaciones.codigo_prestacion','=','CTC010A97')
                            ->whereBetween('prestaciones.prestaciones.fecha_prestacion',[$fecha_inicio_cuatri,$fecha_fin_cuatri])
                            ->select('cuie', DB::raw($periodo),DB::raw('3.3'),DB::raw($id_provincia), DB::raw('count(*) as total'))                            

                            ->groupBy('cuie')
                            ->get();

           //return json_encode($indicadorToInsert);
           $query = DB::getQueryLog();
           return json_encode(print_r($query));
    }

    /**
     * Realiza la query para el indicador 3.3 "denominador"
     * Adolescentes de 10-19 a cargo del efector.
     * @param  int  $id_provincia
     * @param  int  $periodo     
     * @return \Illuminate\Http\Response
     */
    public function indicador_3_3_denominador($id_provincia,$periodo,$fecha)
    {
        return DB::update( " UPDATE indicadores.indicadores_priorizados
                                SET denominador = resultado
                                FROM
                                (
                                    SELECT bp.efector_asignado, count(*) as resultado
                                    FROM efectores.efectores e
                                    INNER JOIN efectores.datos_geograficos eg ON e.id_efector = eg.id_efector                                    
                                    INNER JOIN beneficiarios.beneficiarios_periodos bp ON e.cuie = bp.efector_asignado
                                    INNER JOIN beneficiarios.beneficiarios_ceb bc ON bp.clave_beneficiario = bc.clave_beneficiario AND bp.periodo = bc.periodo
                                    INNER JOIN beneficiarios.beneficiarios b ON bp.clave_beneficiario = b.clave_beneficiario                                                    
                                    WHERE
                                        eg.id_provincia = ?                                          
                                    AND e.priorizado = 'S'              
                                    AND extract (year from (age (?::date , b.fecha_nacimiento))) between 10 and 19                                               
                                    AND bp.periodo = ?    
                                    AND activo = 'S'
                                            
                                    GROUP BY 1
                                    ORDER BY 1
                                ) as res_denominador
                                WHERE efector = efector_asignado
                                AND indicador = ?
                                AND periodo = ?); ",[$id_provincia,$fecha,$periodo,'3.3',$periodo]);
    }

    /**
     * Realiza la query para el indicador 3.4 "numerador"
     * Adolescentes mujeres de 11 años a cargo del efector que hayan cumnplido con el esquema de vacuna de VPH facuturada y aprobada por la SPS.
     * @param  int  $id_provincia
     * @param  int  $periodo     
     * @param  int  $fecha_inicio_cuatri
     * @param  int  $fecha_fin_cuatri
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_3_4_numerador($id_provincia,$anio,$fecha = null,$fecha_inicio_cuatri = null,$fecha_fin_cuatri = null)
    {
        $periodo = $anio . '04';
        $fecha_inicio_cuatri = '2015-01-01';
        $fecha_fin_cuatri = '2015-04-30';
        $fecha = '2015-04-30';

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')                             
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })
                             ->join('beneficiarios.beneficiarios', function($join) use ($fecha)
                                {
                                    $join->on('beneficiarios.periodos.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'12 years\''),'>=',$fecha)
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'10 years\''),'<=',$fecha);
                                })
                             ->join('prestaciones.prestaciones', function($join) use ($fecha_inicio_cuatri,$fecha_fin_cuatri)
                                {
                                    $join->on('prestaciones.prestaciones.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->on('prestaciones.prestaciones.efector','=','efectores.efectores.cuie');                                         
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)
                            ->where('beneficiarios.periodos.activo','=','S')
                            ->where('beneficiarios.beneficiarios.sexo','=','F')                            
                            ->where('prestaciones.prestaciones.codigo_prestacion','=','IMV014A98')
                            ->whereBetween('prestaciones.prestaciones.fecha_prestacion',[$fecha_inicio_cuatri,$fecha_fin_cuatri])
                            ->select('cuie', DB::raw($periodo),DB::raw('3.4'),DB::raw($id_provincia), DB::raw('count(*) as total'))                            

                            ->groupBy('cuie')
                            ->get();

           return json_encode($indicadorToInsert);
    }

    /**
     * Realiza la query para el indicador 3.4 "denominador"
     * Adolescentes mujeres de 11 años a cargo del efector.
     * @param  int  $id_provincia
     * @param  int  $periodo     
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_3_4_denominador($id_provincia,$anio,$fecha = null,$fecha_inicio_cuatri = null,$fecha_fin_cuatri = null)
    {
        $periodo = $anio . '04';
        $fecha = '2015-04-30';

        return DB::update( " UPDATE indicadores.indicadores_priorizados
                                SET denominador = resultado
                                FROM
                                (
                                    SELECT bp.efector_asignado, count(*) as resultado
                                    FROM efectores.efectores e
                                    INNER JOIN efectores.datos_geograficos eg ON e.id_efector = eg.id_efector                                    
                                    INNER JOIN beneficiarios.beneficiarios_periodos bp ON e.cuie = bp.efector_asignado
                                    INNER JOIN beneficiarios.beneficiarios_ceb bc ON bp.clave_beneficiario = bc.clave_beneficiario AND bp.periodo = bc.periodo
                                    INNER JOIN beneficiarios.beneficiarios b ON bp.clave_beneficiario = b.clave_beneficiario                                                    
                                    WHERE
                                        eg.id_provincia = ?                                          
                                    AND e.priorizado = 'S'              
                                    AND extract (year from (age (?::date , b.fecha_nacimiento))) = 11
                                    AND b.sexo = 'F'
                                    AND bp.periodo = ?    
                                    AND activo = 'S'
                                            
                                    GROUP BY 1
                                    ORDER BY 1
                                ) as res_denominador
                                WHERE efector = efector_asignado
                                AND indicador = ?
                                AND periodo = ?); ",[$id_provincia,$fecha,$periodo,'3.4',$periodo]);
    }

     /**
     * Realiza la query para el indicador 4.1 "numerador"
     * Mujeres de 49-64 a cargo del efector con mamografía en los últimos 2 años facturada y aprobada por el SPS (IG R014 A98)
     * @param  int  $id_provincia
     * @param  int  $periodo          
     * @param  int  $fecha
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_4_1_numerador($id_provincia,$anio,$fecha = null)
    {
        $periodo = $anio . '04';        
        $fecha = '2015-04-30';
        $fechaMenos2Años = $fecha . DB::raw(' - interval 2 years');

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')                             
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })
                             ->join('beneficiarios.beneficiarios', function($join) use ($fecha)
                                {
                                    $join->on('beneficiarios.periodos.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'64 years\''),'>=',$fecha)
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'49 years\''),'<=',$fecha);
                                })
                             ->join('prestaciones.prestaciones', function($join) use ($fecha_inicio_cuatri,$fecha_fin_cuatri)
                                {
                                    $join->on('prestaciones.prestaciones.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->on('prestaciones.prestaciones.efector','=','efectores.efectores.cuie');                                         
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)
                            ->where('beneficiarios.periodos.activo','=','S')
                            ->where('beneficiarios.beneficiarios.sexo','=','F')                            
                            ->where('prestaciones.prestaciones.codigo_prestacion','=','IGR014A98')
                            ->where('prestaciones.prestaciones.fecha_prestacion','>',$fechaMenos2Años)
                            ->select('cuie', DB::raw($periodo),DB::raw('4.1'),DB::raw($id_provincia), DB::raw('count(*) as total'))                            

                            ->groupBy('cuie')
                            ->get();

           return json_encode($indicadorToInsert);
    }

     /**
     * Realiza la query para el indicador 4.1 "denominador"
     * Mujeres de 49-64 a cargo del efector.
     * @param  int  $id_provincia
     * @param  int  $periodo          
     * @param  int  $fecha
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_4_1_denominador($id_provincia,$anio,$fecha = null)
    {
        $periodo = $anio . '04';
        $fecha = '2015-04-30';

        return DB::update( " UPDATE indicadores.indicadores_priorizados
                                SET denominador = resultado
                                FROM
                                (
                                    SELECT bp.efector_asignado, count(*) as resultado
                                    FROM efectores.efectores e
                                    INNER JOIN efectores.datos_geograficos eg ON e.id_efector = eg.id_efector                                    
                                    INNER JOIN beneficiarios.beneficiarios_periodos bp ON e.cuie = bp.efector_asignado
                                    INNER JOIN beneficiarios.beneficiarios_ceb bc ON bp.clave_beneficiario = bc.clave_beneficiario AND bp.periodo = bc.periodo
                                    INNER JOIN beneficiarios.beneficiarios b ON bp.clave_beneficiario = b.clave_beneficiario                                                    
                                    WHERE
                                        eg.id_provincia = ?                                          
                                    AND e.priorizado = 'S'              
                                    AND extract (year from (age (?::date , b.fecha_nacimiento))) between 49 and 64
                                    AND b.sexo = 'F'
                                    AND bp.periodo = ?    
                                    AND activo = 'S'
                                            
                                    GROUP BY 1
                                    ORDER BY 1
                                ) as res_denominador
                                WHERE efector = efector_asignado
                                AND indicador = ?
                                AND periodo = ?); ",[$id_provincia,$fecha,$periodo,'4.1',$periodo]);
    }

    /**
     * Realiza la query para el indicador 4.2 "numerador"
     * Mujeres de 25-64 a cargo del efector con lectura PAP en laboratorio de Anatomía/Citología en los últimos 2 años facturada y aprobada por el SPS (AP A001 A98,AP A001 X86,AP A001 X75)
     * @param  int  $id_provincia
     * @param  int  $periodo          
     * @param  int  $fecha
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_4_2_numerador($id_provincia,$anio,$fecha = null)
    {
        $periodo = $anio . '04';        
        $fecha = '2015-04-30';
        $fechaMenos2Años = $fecha . DB::raw(' - interval 2 years');

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')                             
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })                             
                             ->join('beneficiarios.beneficiarios', function($join) use ($fecha)
                                {
                                    $join->on('beneficiarios.periodos.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'64 years\''),'>=',$fecha)
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'25 years\''),'<=',$fecha);
                                })
                             ->join('prestaciones.prestaciones', function($join) use ($fecha_inicio_cuatri,$fecha_fin_cuatri)
                                {
                                    $join->on('prestaciones.prestaciones.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->on('prestaciones.prestaciones.efector','=','efectores.efectores.cuie');                                         
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)
                            ->where('beneficiarios.periodos.activo','=','S')
                            ->where('beneficiarios.beneficiarios.sexo','=','F')                            
                            ->whereIn('prestaciones.prestaciones.codigo_prestacion','=',['APA001A98','APA001X86','APA001X75'])
                            ->where('prestaciones.prestaciones.fecha_prestacion','>',$fechaMenos2Años)
                            ->select('cuie', DB::raw($periodo),DB::raw('4.2'),DB::raw($id_provincia), DB::raw('count(*) as total'))                            

                            ->groupBy('cuie')
                            ->get();

           return json_encode($indicadorToInsert);
    }

    /**
     * Realiza la query para el indicador 4.2 "denominador"
     * Mujeres de 25-64 a cargo del efector.
     * @param  int  $id_provincia
     * @param  int  $periodo          
     * @param  int  $fecha
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_4_2_denominador($id_provincia,$anio,$fecha = null)
    {
        $periodo = $anio . '04';
        $fecha = '2015-04-30';

        return DB::update( " UPDATE indicadores.indicadores_priorizados
                                SET denominador = resultado
                                FROM
                                (
                                    SELECT bp.efector_asignado, count(*) as resultado
                                    FROM efectores.efectores e
                                    INNER JOIN efectores.datos_geograficos eg ON e.id_efector = eg.id_efector                                    
                                    INNER JOIN beneficiarios.beneficiarios_periodos bp ON e.cuie = bp.efector_asignado
                                    INNER JOIN beneficiarios.beneficiarios_ceb bc ON bp.clave_beneficiario = bc.clave_beneficiario AND bp.periodo = bc.periodo
                                    INNER JOIN beneficiarios.beneficiarios b ON bp.clave_beneficiario = b.clave_beneficiario                                                    
                                    WHERE
                                        eg.id_provincia = ?                                          
                                    AND e.priorizado = 'S'              
                                    AND extract (year from (age (?::date , b.fecha_nacimiento))) between 25 and 64
                                    AND b.sexo = 'F'
                                    AND bp.periodo = ?    
                                    AND activo = 'S'
                                            
                                    GROUP BY 1
                                    ORDER BY 1
                                ) as res_denominador
                                WHERE efector = efector_asignado
                                AND indicador = ?
                                AND periodo = ?); ",[$id_provincia,$fecha,$periodo,'4.2',$periodo]);
    }

    /**
     * Realiza la query para el indicador 4.3
     * Mujeres de 25-64 a cargo del efector con citología ASCH,H-SIL,Cáncer (CA cervicouterino) en el último año con diagnóstico por biopsia en laboratorio de anatomía patológica factura y aprobada por la SPS (AP A002 A98,AP A002 X80,AP A002 X75).
     * @param  int  $id_provincia
     * @param  int  $periodo          
     * @param  int  $fecha
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_4_3($id_provincia,$anio,$fecha = null)
    {
        $periodo = $anio . '04';        
        $fecha = '2015-04-30';
        $fechaMenos1Año = $fecha . DB::raw(' - interval 1 year');

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')                             
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })                             
                             ->join('beneficiarios.beneficiarios', function($join) use ($fecha)
                                {
                                    $join->on('beneficiarios.periodos.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'64 years\''),'>=',$fecha)
                                         ->where(DB::raw('beneficiarios.beneficiarios.fecha_nacimiento + interval \'25 years\''),'<=',$fecha);
                                })
                             ->join('prestaciones.prestaciones', function($join)
                                {
                                    $join->on('prestaciones.prestaciones.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->on('prestaciones.prestaciones.efector','=','efectores.efectores.cuie');                                         
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)
                            ->where('beneficiarios.periodos.activo','=','S')
                            ->where('beneficiarios.beneficiarios.sexo','=','F')                            
                            ->whereIn('prestaciones.prestaciones.codigo_prestacion','=',['APA002A98','APA002X80','APA002X75','APA001X86','APA001X75'])
                            ->where('prestaciones.prestaciones.fecha_prestacion','>',$fechaMenos1Año)
                            ->select('cuie', DB::raw($periodo),DB::raw('4.3'),DB::raw($id_provincia), DB::raw($id_provincia), DB::raw('sum(case 
                                                                                                                                        when prestaciones.prestaciones.codigo_prestacion IN (\'APA002A98\',\'APA002X80\',\'APA002X75\') then 1
                                                                                                                                        else 0 end) as resultado1'), DB::raw('sum(case 
                                                                                                                                                                    when prestaciones.prestaciones.codigo_prestacion IN (\'APA001X86\',\'APA001X75\') then 1
                                                                                                                                                                    else 0 end) as resultado2'))                            

                            ->groupBy('cuie')
                            ->get();

           return json_encode($indicadorToInsert);
    }

     /**
     * Realiza la query para el indicador 5.1
     * //Indigenas asignados al efector con cobertura efectiva básica.
     * @param  int  $id_provincia
     * @param  int  $periodo               
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_5_1($id_provincia,$anio)
    {
        $periodo = $anio . '04';        

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })
                             ->join('beneficiarios.ceb', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.ceb.clave_beneficiario','=','beneficiarios.periodos.clave_beneficiario')
                                         ->where('beneficiarios.ceb.periodo','=',$periodo);
                                })
                             ->join('beneficiarios.indigenas', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.ceb.clave_beneficiario','=','beneficiarios.indigenas.clave_beneficiario')
                                         ->where('beneficiarios.ceb.periodo','=',$periodo);
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('beneficiarios.indigenas.declara_indigena','=','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)                                                             
                            ->select('cuie', DB::raw($periodo),DB::raw('5.1'),DB::raw($id_provincia), DB::raw('sum(case ceb
                                                                                    when \'S\' then 1
                                                                                    else 0 end) as res_ceb'), DB::raw('count(*) as total'))                            

                            ->groupBy('cuie')
                            ->get();

        return json_encode($indicadorToInsert);
    }

    /**
     * Realiza la query para el indicador 5.2 "numerador"
     * Indigenas asignados al efector con consulta de salud individual realizada en terreno, facturada y aprobada por el SPS (CTC009A97).
     * @param  int  $id_provincia
     * @param  int  $periodo     
     * @param  int  $fecha_inicio_cuatri
     * @param  int  $fecha_fin_cuatri
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_5_2_numerador($id_provincia,$anio,$fecha = null,$fecha_inicio_cuatri = null,$fecha_fin_cuatri = null)
    {
        $periodo = $anio . '04';
        $fecha_inicio_cuatri = '2015-01-01';
        $fecha_fin_cuatri = '2015-04-30';

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')                             
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo); 
                                })
                             ->join('beneficiarios.indigenas', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.clave_beneficiario','=','beneficiarios.indigenas.clave_beneficiario')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo);
                                })
                             ->join('prestaciones.prestaciones', function($join) use ($fecha_inicio_cuatri,$fecha_fin_cuatri)
                                {
                                    $join->on('prestaciones.prestaciones.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->on('prestaciones.prestaciones.efector','=','efectores.efectores.cuie');                                         
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)
                            ->where('beneficiarios.periodos.activo','=','S')
                            ->where('beneficiarios.indigenas.declara_indigena','=','S')                                                    
                            ->where('prestaciones.prestaciones.codigo_prestacion','=','CTC009A97')
                            ->whereBetween('prestaciones.prestaciones.fecha_prestacion',[$fecha_inicio_cuatri,$fecha_fin_cuatri])
                            ->select('cuie', DB::raw($periodo),DB::raw('5.2'),DB::raw($id_provincia), DB::raw('count(*) as total'))                            

                            ->groupBy('cuie')
                            ->get();

           return json_encode($indicadorToInsert);
    }

    /**
     * Realiza la query para el indicador 5.2 "denominador"
     * Indigenas asignados al efector.
     * @param  int  $id_provincia
     * @param  int  $periodo          
     * @param  int  $fecha
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_5_2_denominador($id_provincia,$anio,$fecha = null)
    {
        $periodo = $anio . '04';
        $fecha = '2015-04-30';

        return DB::update( " UPDATE indicadores.indicadores_priorizados
                                SET denominador = resultado
                                FROM
                                (
                                    SELECT bp.efector_asignado, count(*) as resultado
                                    FROM efectores.efectores e
                                    INNER JOIN efectores.datos_geograficos eg ON e.id_efector = eg.id_efector                                    
                                    INNER JOIN beneficiarios.beneficiarios_periodos bp ON e.cuie = bp.efector_asignado
                                    INNER JOIN beneficiarios.beneficiarios_ceb bc ON bp.clave_beneficiario = bc.clave_beneficiario AND bp.periodo = bc.periodo
                                    INNER JOIN beneficiarios.beneficiarios b ON bp.clave_beneficiario = b.clave_beneficiario                                                    
                                    WHERE
                                        eg.id_provincia = ?                                          
                                    AND e.priorizado = 'S' 
                                    AND declara_indigena = 'S'                                                                                     
                                    AND bp.periodo = ?    
                                    AND activo = 'S'
                                            
                                    GROUP BY 1
                                    ORDER BY 1
                                ) as res_denominador
                                WHERE efector = efector_asignado
                                AND indicador = ?
                                AND periodo = ?); ",[$id_provincia,$periodo,'5.2',$periodo]);
    }

    /**
     * Realiza la query para el indicador 5.3
     * Número de ronda sanitaria completa orientada a la detección de población indígena realizadas y facturadas por el efector (ROX002A98).
     * @param  int  $id_provincia
     * @param  int  $periodo     
     * @param  int  $fecha_inicio_cuatri
     * @param  int  $fecha_fin_cuatri
     * @return \Illuminate\Http\Response
     */
    public function getIndicador_5_3($id_provincia,$anio,$fecha_inicio_cuatri = null,$fecha_fin_cuatri = null)
    {
        $periodo = $anio . '04';
        $fecha_inicio_cuatri = '2015-01-01';
        $fecha_fin_cuatri = '2015-04-30';

        $indicadorToInsert = DB::table('efectores.efectores')                             
                             ->join('efectores.datos_geograficos','efectores.efectores.id_efector','=','efectores.datos_geograficos.id_efector')
                             ->join('beneficiarios.periodos', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.efector_asignado','=','efectores.efectores.cuie')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo);
                                })
                             ->join('beneficiarios.indigenas', function($join) use ($periodo)
                                {
                                    $join->on('beneficiarios.periodos.clave_beneficiario','=','beneficiarios.indigenas.clave_beneficiario')
                                         ->where('beneficiarios.periodos.periodo','=',$periodo);
                                })
                             ->join('prestaciones.prestaciones', function($join)
                                {
                                    $join->on('prestaciones.prestaciones.clave_beneficiario','=','beneficiarios.beneficiarios.clave_beneficiario')
                                         ->on('prestaciones.prestaciones.efector','=','efectores.efectores.cuie');
                                })
                            ->where('efectores.efectores.priorizado','S')
                            ->where('efectores.datos_geograficos.id_provincia','=',$id_provincia)
                            ->where('beneficiarios.periodos.activo','=','S')
                            ->where('beneficiarios.indigenas.declara_indigena','=','S')   
                            ->where('prestaciones.prestaciones.codigo_prestacion','=','ROX002A98')
                            ->whereBetween('prestaciones.prestaciones.fecha_prestacion',[$fecha_inicio_cuatri,$fecha_fin_cuatri])
                            ->select('cuie', DB::raw($periodo),DB::raw('5.3'),DB::raw($id_provincia), DB::raw('count(*) as total'))

                            ->groupBy('cuie')
                            ->get();

           return json_encode($indicadorToInsert);
    }

}
