<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Usuario;

class UsuariosDoiTokenCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = "doi3:token";

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Agregar token a los usuarios que pueden ver el modulo de doi3";

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
        $usuarios = DB::select('select id_usuario from sistema.usuarios where id_menu in (select id_menu from sistema.modulos_menu where id_modulo = 3) order by id_usuario');

   	 	foreach($usuarios as $usuario){
        	$user = Usuario::find($usuario->id_usuario);
	        $this->info($user->id_usuario);
	        $faker = \Faker\Factory::create();
	        $user->token = $faker->uuid;
	        $this->info($user->token);
	        //$user->save();
	    }

	}
}
