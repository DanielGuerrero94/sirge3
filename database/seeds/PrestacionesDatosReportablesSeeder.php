<?php

use Illuminate\Database\Seeder;

class PrestacionesDatosReportablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::connection('prestaciones')->statement("INSERT INTO prestaciones.datos_reportables (nombre,grupo_etario,datos)

		values
		('Peso','S','{\"datos_0\":{\"id_grupo_etario\":6,\"min\":0.5,\"max\":30},\"datos_1\":{\"id_grupo_etario\":8,\"min\":0.5,\"max\":100}}'),
		('Talla','S','{\"datos_0\":{\"id_grupo_etario\":9,\"min\":45,\"max\":190}}'),
		('Toma de TA','N','{\"datos_0\":{\"valor_1\":\"not_null\"}}'),
		('Perímetro cefálico','N','{\"datos_0\":{\"min\":30,\"max\":54}}'),
		('Registro de edad gestacional','N','{\"datos_0\":{\"valor_1\":\"not_null\"}}'),
		('Índice CPOD y/o ceod  según corresponda','S','{\"datos_0\":{\"id_grupo_etario\":7,\"valor_1\":\"CEO\"},\"datos_1\":{\"id_grupo_etario\":10,\"valor_1\":\"CPO\"}}'),
		('Resultado OEA en Oído derecho/ Oído izquierdo','N','{\"datos_0\":{\"valor_1\":\"ODpasa\",\"valor_2\":\"ODnopasa\",\"valor_3\":\"OIpasa\",\"valor_4\":\"OInopasa\"}}'),
		('Resulado grado de retinopatía','N','{\"datos_0\":{\"min\":0,\"max\":5}}'),
		('Informe o transcripción de estudios solicitados
		(Prestación: Anatomía patológica de biopsia (CA mama) )','N','{\"datos_0\":{\"min\":1,\"max\":7}}'),
		('Informe o transcripción de estudios solicitados
		(Prestación: Diagnóstico por biopsia en laboratorio de anatomía patológica, para aquellas mujeres con citología ASC-H, H-SIL,Cáncer (CA cervicouterino))','N','{\"datos_0\":{\"min\":1,\"max\":7}}'),
		('Informe o transcripción de estudios solicitados
		(Prestación: Lectura de la muestra tomada en mujeres entre 25 y 64 años)','N','{\"datos_0\":{\"min\":1,\"max\":8}}'),
		('Informe o transcripción de estudios solicitados
		(Prestación: Mamografía bilateral, craneocaudal y oblicua, con proyección axilar  mujeres (en mayores de 49 años)','N','{\"datos_0\":{\"min\":0,\"max\":5}}'),
		('Informe o transcripción de estudios solicitadoss(Prestación VDRL)','N','{\"datos_0\":{\"valor_1\":\"+\",\"valor_2\":\"-\"}}'),
		('Tratamiento instaurado (Prestación: Notificación de inicio de tratamiento)','N','{\"datos_0\":{\"min\":1,\"max\":3}}');
		");
    }
}
