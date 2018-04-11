<?php

use Illuminate\Database\Seeder;

class PrestacionesRequiereDatosReportables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::connection('produccion')->statement("INSERT INTO prestaciones.requiere_datos_reportables (codigo_prestacion,grupo_etario,datos) 		
		values
		('CTC005W78','N','{\"ids\":[1,5,3]}'),
		('CTC006W78','N','{\"ids\":[1,5,3]}'),
		('CTC007O24.4','N','{\"ids\":[1,5,3]}'),
		('CTC022O24.4','N','{\"ids\":[1,5,3]}'),
		('CTC007O10','N','{\"ids\":[1,5,3]}'),
		('CTC007O10.4','N','{\"ids\":[1,5,3]}'),
		('CTC022O10','N','{\"ids\":[1,5,3]}'),
		('CTC022O10.4','N','{\"ids\":[1,5,3]}'),
		('CTC007O16','N','{\"ids\":[1,5,3]}'),
		('CTC022O16','N','{\"ids\":[1,5,3]}'),
		('CTC017P05','N','{\"ids\":[1,5,3]}'),
		('PRP021A97','S','[{\"id_grupo_etario\":10,\"ids\":[7,7]}]'),
		('PRP021H86','S','[{\"id_grupo_etario\":10,\"ids\":[7,7]}]'),
		('PRP017A46','S','[{\"id_grupo_etario\":10,\"ids\":[8]}]'),
		('PRP017A97','S','[{\"id_grupo_etario\":10,\"ids\":[8]}]'),
		('CTC001A97','S','[{\"id_grupo_etario\":1,\"ids\":[1,2,4]},{\"id_grupo_etario\":2,\"ids\":[1,2]},{\"id_grupo_etario\":3,\"ids\":[1,2,3]},{\"id_grupo_etario\":4,\"ids\":[3]}]'),
		('CTC009A97','S','[{\"id_grupo_etario\":3,\"ids\":[1,2,3]},{\"id_grupo_etario\":4,\"ids\":[3]}]'),
		('APA002A98','S','[{\"id_grupo_etario\":4,\"ids\":[10]}]'),
		('APA002X75','S','[{\"id_grupo_etario\":4,\"ids\":[10]}]'),
		('APA002X80','S','[{\"id_grupo_etario\":4,\"ids\":[10]}]'),
		('APA002X76','S','[{\"id_grupo_etario\":4,\"ids\":[9]}]'),
		('LBL119Dxx','S','[{\"id_grupo_etario\":4,\"ids\":[13]}]'),
		('CTC010W78','N','{\"ids\":[6]}'),
		('CTC010A97','N','{\"ids\":[6]}'),
		('CTC001T79','S','[{\"id_grupo_etario\":3,\"ids\":[1,2,3]}]'),
		('CTC001T82','S','[{\"id_grupo_etario\":3,\"ids\":[1,2,3]}]'),
		('CTC002T79','S','[{\"id_grupo_etario\":3,\"ids\":[1,2,3]}]'),
		('CTC002T82','S','[{\"id_grupo_etario\":3,\"ids\":[1,2,3]}]'),
		('CTC001T83','S','[{\"id_grupo_etario\":3,\"ids\":[1,2,3]}]'),
		('CTC002T83','S','[{\"id_grupo_etario\":3,\"ids\":[1,2,3]}]'),
		('IGR014A98','S','[{\"id_grupo_etario\":4,\"ids\":[12]}]'),
		('APA001A98','S','[{\"id_grupo_etario\":4,\"ids\":[11]}]'),
		('APA001X86','S','[{\"id_grupo_etario\":4,\"ids\":[11]}]'),
		('APA001X75','S','[{\"id_grupo_etario\":4,\"ids\":[11]}]'),
		('NTN002X75','S','[{\"id_grupo_etario\":4,\"ids\":[14]}]')");
    }
}
