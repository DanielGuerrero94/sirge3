<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tarea.php;
use App\Models\TareasResultado.php;
use App\Models\Dw\FC\Fc001.php;
use App\Models\Dw\FC\Fc002.php;
use App\Models\Dw\FC\Fc003.php;
use App\Models\Dw\FC\Fc004.php;
use App\Models\Dw\FC\Fc005.php;
use App\Models\Dw\FC\Fc006.php;
use App\Models\Dw\FC\Fc007.php;
use App\Models\Dw\FC\Fc008.php;
use App\Models\Dw\FC\Fc009.php;
use App\Models\Dw\UF\Uf001.php;
use App\Models\Dw\CEB\Ceb001.php;
use App\Models\Dw\CEB\Ceb002.php;
use App\Models\Dw\CA\CA16001.php;



class DatawarehouseController extends Controller
{
    
   public function ejecutarTodas($periodo)
    {                        
        if(! Tarea::where('estado',1)->first() ){
            $this->Fc001($periodo);
            $this->Fc002($periodo);
            $this->Fc003($periodo);
            $this->Fc004($periodo);
            $this->Fc005($periodo);
            $this->Fc006($periodo);
            $this->Fc007($periodo);
            $this->Fc008($periodo);
            $this->Fc009($periodo);            
        }        
    }

    protected function cargarComienzoTarea($nombre_function, $periodo){               

        if(! TareasResultado::where('tarea',Tarea::where('nombre',$nombre_function)->first()->id)
                            ->where('periodo',$periodo)->first() )
        {
            $tarea = new TareasResultado();
            $tarea->periodo = $periodo;
            $tarea->tarea = Tarea::where('nombre',$nombre_function)->first()->id;
            $tarea->finalizado = 0;
            $tarea->tiempo_de_ejecucion = 0;
            $saved = $tarea->save();
            if(!$saved){
                App::abort(500, 'Error');
            }    
        }
    }

    protected function cargarFinalTarea($nombre_function, $periodo, $start){
         
        $tarea = TareasResultado::where('tarea',Tarea::where('nombre',$nombre_function)->first()->id)
                                ->where('periodo',$periodo)
                                ->update(['finalizado'=> 1, 'tiempo_de_ejecucion' => (microtime(true) - $start)]);       
    }        

    /**
     * Busca el archivo sql correspondiente y actualiza la tabla de FC001
     *     
     * 
     */
    public function Fc001($periodo)
    {           
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)                    
                        ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            //$sql = file_get_contents($_SERVER['DOCUMENT_ROOT'] . 'app/SQL/fc_001.sql');
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc001::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]);
        }                 
    }

    /**
     * Trunca y actualiza la tabla de FC002
     *     
     * 
     */
    public function Fc002($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc002::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]);         
        } 
    }

    /**
     * Trunca y actualiza la tabla de FC003
     *     
     * 
     */
    public function Fc003($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc003::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start); 
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]);
        } 
    }

    /**
     * Trunca y actualiza la tabla de FC004
     *     
     * 
     */
    public function Fc004($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc004::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de FC005
     *     
     * 
     */
    public function Fc005($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc005::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de FC006
     *     
     * 
     */
    public function Fc006($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc006::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de FC007
     *     
     * 
     */
    public function Fc007($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc007::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de FC008
     *     
     * 
     */
    public function Fc008($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc008::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de FC009
     *     
     * 
     */
    public function Fc009($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Fc009::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de AF001
     *     
     * 
     */
    public function Af001($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Af001::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de CA16001
     *     
     * 
     */
    public function Ca16001($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Ca16001::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de CEB001
     *     
     * 
     */
    public function Ceb001($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Ceb001::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Trunca y actualiza la tabla de CEB002
     *     
     * 
     */
    public function Ceb002($periodo)
    {   
        $this->cargarComienzoTarea(__FUNCTION__, $periodo);
        if((TareasResultado::where('tarea',Tarea::where('nombre',__FUNCTION__)->first()->id)
                            ->where('periodo',$periodo)->first()->finalizado) == 0)
        { 
            $start = microtime(true);
            $sql = Tarea::where('nombre',__FUNCTION__)->first()->query;
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 1]);
            Ceb002::truncate();
            $this->run_multiple_statements($sql);
            $this->cargarFinalTarea(__FUNCTION__, $periodo, $start);
            Tarea::where('nombre',__FUNCTION__)->update(['estado'=> 2]); 
        } 
    }

    /**
     * Ejecuta los statements de la query enviada
     *     
     * 
     */
    public function run_multiple_statements($statement)
    {          
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $statement)));                
 

        foreach ($statements as $stmt) {            
            if(! DB::connection('datawarehouse')->getPdo()->exec($stmt)){
                echo "Error en la conexion o query";
            }
        }
     }
}
