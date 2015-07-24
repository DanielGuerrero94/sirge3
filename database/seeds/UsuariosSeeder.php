<?php

use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sistema.usuarios')->insert([
        	'usuario' => 'gustavo',
        	'password' => bcrypt('homero'),
        	'nombre' => 'Gustavo D. Hekel',
        	'email' => 'gustavo.hekel@gmail.com',
        	'activo' => 'S',
        	'id_provincia' => '01',
        	'id_entidad' => '1',
        	'id_area' => '1',
        	'id_menu' => '1',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => date('Y-m-d H:i:s')
    	]);

        DB::table('sistema.usuarios')->insert([
            'usuario' => 'rodrigo',
            'password' => bcrypt('homero'),
            'nombre' => 'Rodrigo Cadaval',
            'email' => 'rodrigoplansumar@gmail.com',
            'activo' => 'S',
            'id_provincia' => '01',
            'id_entidad' => '1',
            'id_area' => '1',
            'id_menu' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('sistema.usuarios')->insert([
            'usuario' => 'javier',
            'password' => bcrypt('homero'),
            'nombre' => 'Javier E. Minsky',
            'email' => 'jminsky@gmail.com',
            'activo' => 'S',
            'id_provincia' => '04',
            'id_entidad' => '1',
            'id_area' => '1',
            'id_menu' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('sistema.usuarios')->insert([
            'usuario' => 'ariel',
            'password' => bcrypt('homero'),
            'nombre' => 'Ariel J.',
            'email' => 'arielplan@gmail.com',
            'activo' => 'S',
            'id_provincia' => '13',
            'id_entidad' => '1',
            'id_area' => '1',
            'id_menu' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('sistema.usuarios')->insert([
            'usuario' => 'alejandro',
            'password' => bcrypt('homero'),
            'nombre' => 'Alejandro Crapanzano',
            'email' => 'alejandroplan@gmail.com',
            'activo' => 'S',
            'id_provincia' => '01',
            'id_entidad' => '1',
            'id_area' => '1',
            'id_menu' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
