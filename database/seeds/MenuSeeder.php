<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sistema.menues')->insert([
        	'descripcion' => 'SUPER ADMIN'
    	]);
    }
}
