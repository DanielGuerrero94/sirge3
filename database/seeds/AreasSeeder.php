<?php

use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sistema.areas')->insert([
        	'nombre' => 'SISTEMAS'
    	]);
    }
}
