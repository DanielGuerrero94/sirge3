<?php

use Illuminate\Database\Seeder;

class SistemaUsuarios extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.usuarios(id_usuario,usuario,password,nombre,email,activo,id_area,id_menu,telefono,id_provincia,id_entidad,last_login,created_at,updated_at)
 (
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
	    'SELECT id_usuario,usuario,password,descripcion as nombre,email,activo,id_area,id_menu,null as telefono,case id_entidad when ''25'' then ''01'' else id_entidad end as id_provincia,case id_entidad when ''25'' then 1 else 2 end as id_entidad,now() as last_login,now() as created_at, now() as updated_at
		    FROM sistema.usuarios')
	    AS migracion( id_usuario integer,
			  usuario character varying(50),
			  password character varying(100),
			  nombre character varying(100),
			  email character varying(50),
			  activo character(1),
			  id_area integer,
			  id_menu integer,
			  telefono character varying(20),
			  id_provincia character(2),
			  id_entidad integer,
			  last_login timestamp(0) without time zone,
			  created_at timestamp(0) without time zone,
			  updated_at timestamp(0) without time zone
		)
 );");

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
	WHERE id_usuario = id_user ;");

		\DB::statement(" UPDATE sistema.usuarios SET ruta_imagen = 'public/img/users/unknown_user.png' WHERE ruta_imagen is null;");
	}
}
