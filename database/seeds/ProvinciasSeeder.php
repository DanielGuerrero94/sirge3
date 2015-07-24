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

        DB::table('sistema.provincias')->insert([
            'id_provincia' => '04',
            'id_region' => 1,
            'descripcion' => 'Córdoba'
        ]);

        DB::table('sistema.provincias')->insert([
            'id_provincia' => '13',
            'id_region' => 1,
            'descripcion' => 'Santa Fe'
        ]);

    }
}
