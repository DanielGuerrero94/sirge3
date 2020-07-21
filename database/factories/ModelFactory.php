<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Subida::class, function ($faker) {
	$original_name = 'CABA-02.csv';
	$nombre_archivo = 'CABA-10.csv';
	$size = 10240;
	$id_padron = 10;
	return [
		'id_padron' => $id_padron,
		'nombre_original' => $original_name,
		'nombre_actual' => $nombre_archivo,
		'size' => $size
	];
});

$factory->define(App\Models\PrestacionDOIFacturada::class, function ($faker) {
    //Format 'B90838'
    $letra = $faker->randomLetter();
    //$cuie = strtoupper($letra) . $faker->randomNumber(5, true);
    $cuie = 'B90838';
    //$prestacion_codigo = 'AP' . 'A' . $faker->randomNumber(3, true) . $faker->randomNumber(3, true);
    $prestacion_codigo = 'APA003001';
    $beneficiario_clave = $faker->randomNumber(8, true);

    $valor_unitario_facturado = $faker->randomFloat(2, 0, 9999);
    $cantidad_facturado = $faker->randomDigitNotNull;
    $importe_prestacion_facturado = $valor_unitario_facturado * $cantidad_facturado;


    $data = [
        'id_provincia' => '01',
        'id_prestacion' => $faker->randomNumber(6),
        'prestacion_codigo' => $prestacion_codigo,
        'cuie' => $cuie,
        'prestacion_fecha' => $faker->date('Y-m-d'),
        'beneficiario_apellido' => $faker->lastName,
        'beneficiario_nombre' => $faker->firstName(),
        'beneficiario_clave' => $beneficiario_clave,
        'beneficiario_tipo_documento' => $faker->randomElement(['DNI', 'CI']),
        'beneficiario_clase_documento' => $faker->randomElement(['P', 'A', 'C']),
        'beneficiario_nro_documento' => $faker->randomNumber(8),
        'beneficiario_sexo' => $faker->randomElement(['M', 'F']),
        'beneficiario_nacimiento' => $faker->date('Y-m-d'),
        'valor_unitario_facturado' => $valor_unitario_facturado,
        'cantidad_facturado' => $cantidad_facturado,
        'importe_prestacion_facturado' => $importe_prestacion_facturado,
        'id_factura' => $faker->randomNumber(6),
        'factura_nro' => $faker->randomDigit,
        'factura_fecha' => $faker->date('Y-m-d'),
        'factura_importe_total' => $importe_prestacion_facturado + $faker->randomFloat(2, 0, 99999),
        'factura_fecha_recepcion' => $faker->date('Y-m-d'),
        'alta_complejidad' => $faker->randomElement(['S', 'N'])
    ];

    return $data;
});

$factory->define(App\Models\PrestacionDOILiquidada::class, function ($faker) {
    //Format 'B90838'
    $letra = $faker->randomLetter();
    //$cuie = strtoupper($letra) . $faker->randomNumber(5, true);
    $cuie = 'B90838';
    //$prestacion_codigo = 'AP' . 'A' . $faker->randomNumber(3, true) . $faker->randomNumber(3, true);
    $prestacion_codigo = 'APA003001';
    $beneficiario_clave = $faker->randomNumber(8, true);

    $valor_unitario_facturado = $faker->randomFloat(2, 0, 9999);
    $cantidad_facturado = $faker->randomDigitNotNull;
    $importe_prestacion_facturado = $valor_unitario_facturado * $cantidad_facturado;


    //Liquidada
    $valor_unitario_aprobado = $faker->randomFloat(2, 0, 9999);
    $cantidad_aprobada = $faker->randomDigitNotNull;
    $importe_prestacion_aprobado = $valor_unitario_aprobado * $cantidad_aprobada;

    $data = [
        'id_provincia' => '01',
        'id_prestacion' => $faker->randomNumber(6),
        'prestacion_codigo' => $prestacion_codigo,
        'cuie' => $cuie,
        'prestacion_fecha' => $faker->date('Y-m-d'),
        'beneficiario_apellido' => $faker->lastName,
        'beneficiario_nombre' => $faker->firstName(),
        'beneficiario_clave' => $beneficiario_clave,
        'beneficiario_tipo_documento' => $faker->randomElement(['DNI', 'CI']),
        'beneficiario_clase_documento' => $faker->randomElement(['P', 'A', 'C']),
        'beneficiario_nro_documento' => $faker->randomNumber(8),
        'beneficiario_sexo' => $faker->randomElement(['M', 'F']),
        'beneficiario_nacimiento' => $faker->date('Y-m-d'),
        'valor_unitario_facturado' => $valor_unitario_facturado,
        'cantidad_facturado' => $cantidad_facturado,
        'importe_prestacion_facturado' => $importe_prestacion_facturado,
        'id_factura' => $faker->randomNumber(6),
        'factura_nro' => $faker->randomDigit,
        'factura_fecha' => $faker->date('Y-m-d'),
        'factura_importe_total' => $importe_prestacion_facturado + $faker->randomFloat(2, 0, 99999),
        'factura_fecha_recepcion' => $faker->date('Y-m-d'),
        'alta_complejidad' => $faker->randomElement(['S', 'N']),
	//Liquidada
'id_liquidacion' => $faker->randomNumber(6),
'liquidacion_fecha' => $faker->date('Y-m-d'),
'valor_unitario_aprobado' => $valor_unitario_aprobado,
'cantidad_aprobada' => $cantidad_aprobada,
'importe_prestacion_aprobado' => $importe_prestacion_aprobado
    ];

    return $data;
});
