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
     * Trunca y actualiza la tabla de FC001
     *     
     * 
     */
    public function Fc001()
    {   
        $sql = file_get_contents(__DIR__ . '/queries_guardadas/fc_001.sql');        

        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::connection('datawarehouse')->statement($stmt);
        }
    }
}
