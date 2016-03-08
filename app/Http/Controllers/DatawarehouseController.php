<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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

    /*if (! str_contains($sql, ['DELETE', 'TRUNCATE'])) {
            throw new Exception('Invalid sql file. This will not empty the tables first.');
        }
    */

    /**
     * Busca el archivo sql correspondiente y actualiza la tabla de FC001
     *     
     * 
     */
    public function Fc001()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_001.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de FC002
     *     
     * 
     */
    public function Fc002()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_002.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de FC003
     *     
     * 
     */
    public function Fc003()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_003.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de FC004
     *     
     * 
     */
    public function Fc004()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_004.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de FC005
     *     
     * 
     */
    public function Fc005()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_005.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de FC006
     *     
     * 
     */
    public function Fc006()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_006.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de FC007
     *     
     * 
     */
    public function Fc007()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_007.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de FC008
     *     
     * 
     */
    public function Fc008()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_008.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de FC009
     *     
     * 
     */
    public function Fc009()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/fc_009.sql');        
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de AF001
     *     
     * 
     */
    public function Af001()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/af_001.sql');                
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de CA16001
     *     
     * 
     */
    public function Ca16001()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/ca_16_001.sql');                
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de CEB001
     *     
     * 
     */
    public function Ceb001()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/ceb_001.sql');                
        $this->run_multiple_statements($sql);
    }

    /**
     * Trunca y actualiza la tabla de CEB002
     *     
     * 
     */
    public function Ceb002()
    {   
        $sql = file_get_contents(__DIR__ . 'app/SQL/ceb_002.sql');                
        $this->run_multiple_statements($sql);
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
            DB::connection('datawarehouse')->statement($stmt);
        }
    }
}
