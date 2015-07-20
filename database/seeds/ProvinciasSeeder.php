<?php

use Illuminate\Database\Seeder;

class ProvinciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sistema.provincias')->insert([
        	'id_provincia' => '01',
        	'id_region' => 1,
        	'descripcion' => 'CABA'
    	]);
    }
}
