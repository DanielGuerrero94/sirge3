<?php

use Illuminate\Database\Seeder;

class SistemaUsuarios extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.menues(id_menu,descripcion)
 (
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
	    'SELECT *
		    FROM sistema.menues')
	    AS sirge_menues(id_menu integer, descripcion character varying(100))
 )
        			   	");

		\DB::statement(" UPDATE sistema.usuarios SET ruta_imagen = ruta, fecha_nacimiento = nacimiento, ocupacion = ocup, facebook = face, twitter = twr, linkedin = lk, google_plus = plus, skype = sk, cargo = car, mensaje = men
	FROM
		dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
	    'SELECT id_usuario,ruta_imagen,fecha_nacimiento,ocupacion,facebook,twitter,linkedin,google_plus,skype,cargo,mensaje
		    FROM sistema.usuarios')
	    AS sirge_usuarios(
			  id_user integer,
			  ruta character varying,
			  nacimiento date,
			  ocup character varying(30),
			  face character varying(200),
			  twr character varying(200),
			  lk character varying(200),
			  plus character varying(200),
			  sk character varying(200),
			  car character varying(100),
			  men text
			  )
	WHERE id_usuario = id_user ;

	UPDATE sistema.usuarios SET ruta_imagen = 'public/img/users/unknown_user.png' WHERE ruta_imagen is null;"
		);

	}
}
