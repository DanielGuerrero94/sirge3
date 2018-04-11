<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Req extends Command
{
    private $lotes2 = ['7615','7769','7949','8131','8275','8435','8627'];
    private $lotes = [8906,8995,8924,8896,8914,9040,9037,9003,8949,8927,8926,8909,8942,8962,9053,8983,8985,9009,
        9010,9011,9047,9048,9049,9050,9051,9052,8975,8978,8979,8982,8952,8901,9035,8923,8959,8919,8904,8903,8974,8981,
        8935];

        private $id_provincia = 16;
    //private $lotesMedica = [7821,7839,8184,8185,8328,8491,8640,8845];
    //El ultimo es de cordoba
    // private $lotesMedica = [8421,8557,8720,8901,9035,11057,7769];
    //private $lotesMedica = [8435,8627,8786,8924];

    //[7769,7949,8131,8275,8435,8627,8786,8924,9115];
        // private $lotesMedica = [7753,7759,7769,7934,7946,7949,7978,7983,7984,8095,8106,8120,8123,8131,8147,8183,8273,8275,
        //     8289,8343,8353,8435,8447,8463,8493,8504,8529,8565,8576,8598,8613,8627,8636,8658,8688,8718,8728,8749,8762,8764,
        //     8779,8786,8838,8881,8914,8924,8942,9000,9072,9087,9115,11063,11067,11073];
        //private $lotesMedica = [7769,7949,8131,8275,8435,8627,8786,8924,9115];

        /*
         * Region 2
         */
        /*private $lotesMedica = [7749,7781,7786,7817,7821,7839,7934,7983,8001,8005,8008,8096,8097,8098,8147,8184,8185,
            8265,8296,8298,8328,8343,8456,8464,8491,8493,8576,8592,8628,8629,8636,8640,8737,8740,8749,8752,8845,8896,
            8903,8904,8923,8952,9071,9121,9122,9133,9145];*/
            
        /*
         * Region 3
         * @var
         */
        /*private $lotesMedica = [7663,7697,7829,7851,7853,7919,7963,7986,7994,7995,7998,8013,8014,8018,8030,8088,8089,
            8090,8091,8092,8093,8152,8162,8177,8227,8228,8229,8230,8236,8238,8259,8336,8356,8370,8405,8406,8407,8408,
            8409,8414,8417,8431,8506,8512,8525,8567,8568,8569,8570,8571,8572,8639,8645,8680,8718,8804,8810,8835,8837,
            8839,8840,8842,8843,8846,8872,8885,8949,8975,8978,8979,8982,8983,8985,8995,9040,9047,9048,9049,9050,9051,
            9053,9143,9174];*/

        /*
         * Region 4
         * @var
         */
        /*private $lotesMedica = [7784,7823,7937,8020,8070,8117,8171,8180,8203,8282,8303,8350,8395,8445,8477,8479,8492,
        8495,8606,8608,8616,8656,8657,8768,8794,8799,8807,8833,8909,8926,8927,9003,9037,9191];*/

        /*
         * Region 5
         * @var
         */
        private $lotesMedica = [7554,7632,7639,7671,7794,7830,7871,7873,7875,7957,7987,8023,8074,8075,8077,8099,8126,
            8134,8187,8319,8339,8344,8357,8421,8471,8486,8489,8504,8538,8557,8574,8575,8582,8655,8658,8720,8746,8759,
            8761,8825,8826,8827,8828,8838,8901,8919,8974,8981,9035,9126,9176,9182,11057,11068,11086];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:req';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
        $lotes = $this->lotesDiciembre();
    //        $lotes = $this->lotesNoviembre();
    //$lotes = $this->lotesOctubre();

        $lotes = array_map(function ($lote) {
            return $lote->lote;
        }, $lotes);
*/
        //$lotes = [11259,11105,11256,11257,11104,11258,11260,11261,11102,11101,11100];
/*
	$lotes = DB::table('sistema.lotes as l')
	->leftJoin('logs.revision as r', 'r.lote', '=', 'l.lote')
	->select('l.lote')
	->where('id_estado', 3)
	->whereYear('inicio', '=', 2018)
	->whereNull('r.id_prestacion')
	//->take(50)
	->get('l.lote');
	*/
	$lotes = DB::select("select lote from sistema.lotes left join logs.revision using(lote) where id_estado = 3 and inicio::date >= '2018-01-01' and id_prestacion is null limit 10");

//	$in = "";

        foreach ($lotes as $lote) {
   		exec("nohup php artisan get:datos-reportables -l {$lote->lote} > /dev/null 2>&1 &");
//		$in .= ",".strval($lote->lote);
//            $this->info($lote->lote);
            /*exec("nohup php artisan get:queries-csv -l {$lote} > /dev/null 2>&1 &");*/
        }
//	$this->info($in);
        $this->info("Lotes procesando");
    }

    public function lotesOctubre()
    {
        return DB::select("select l.lote from sistema.lotes l join sistema.subidas s on s.id_subida = l.id_subida
            left join logs.revision r on r.lote = l.lote where r.id_revision is null and l.inicio
            between '2017-07-01' and '2017-10-01' and l.id_estado = 3 and s.id_padron = 1;");
    }



    public function lotesNoviembre()
    {
        return DB::select("select l.lote from sistema.lotes l join sistema.subidas s on s.id_subida = l.id_subida left join logs.revision r on r.lote = l.lote where r.id_revision is null and l.inicio between '2017-11-01' and '2017-12-01' and l.id_estado = 3 and s.id_padron = 1;");
    }


    public function lotesDiciembre()
    {
        return DB::select("select l.lote from sistema.lotes l join sistema.subidas s on s.id_subida = l.id_subida left join logs.revision r on r.lote = l.lote where r.id_revision is null and l.inicio >= '2017-12-01' and l.id_estado = 3 and s.id_padron = 1;");
    }

    public function dr8()
    {
        return $query = "select pro.descripcion as provincia,pro.id_provincia, pre.codigo_prestacion, ger.descripcion as grupo_etario
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario
        join temporales.grupos_etarios_req_dr ge on age(p.fecha_prestacion, b.fecha_nacimiento) between ge.edad_min and ge.edad_max
        where ausentes->'ids' ?& array['8']
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia
        and ge.id = ger.id) as \"8-ausentes\"
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario
        join temporales.grupos_etarios_req_dr ge on age(p.fecha_prestacion, b.fecha_nacimiento) between ge.edad_min and ge.edad_max
        where errores->'ids' ?& array['8']
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia
        and ge.id = ger.id) as \"8-errores\"
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario
        join temporales.grupos_etarios_req_dr ge on age(p.fecha_prestacion, b.fecha_nacimiento) between ge.edad_min and ge.edad_max
        where (ausentes->'ids' ?& array['8'] or errores->'ids' ?& array['8'])
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia
        and ge.id = ger.id) as \"prestaciones-no-validos\"
        ,(select count(*)
        from prestaciones.prestaciones p
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario
        join temporales.grupos_etarios_req_dr ge on age(p.fecha_prestacion, b.fecha_nacimiento) between ge.edad_min and ge.edad_max
        where p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia
        and ge.id = ger.id) as \"total-prestaciones\"
        from logs.revision r
        join prestaciones.prestaciones pre on pre.id = r.id_prestacion
        join efectores.efectores e on e.cuie = pre.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        join geo.provincias pro on pro.id_provincia = dg.id_provincia
        join beneficiarios.beneficiarios b on b.clave_beneficiario = pre.clave_beneficiario
        join temporales.grupos_etarios_req_dr ger on age(pre.fecha_prestacion, b.fecha_nacimiento) between ger.edad_min and ger.edad_max
        where pre.codigo_prestacion in ('PRP017A46','PRP017A97')
        group by pro.descripcion,pro.id_provincia, pre.codigo_prestacion, ger.id, ger.descripcion
        order by pro.id_provincia,pre.codigo_prestacion, ger.id";
    }

    public function dr9()
    {
        $query = "select pro.id_provincia, pre.codigo_prestacion
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        where ausentes->'ids' ?& array['9']
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia) as \"9-ausentes\"
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        where errores->'ids' ?& array['9']
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia) as \"9-errores\"
        from logs.revision r
        join prestaciones.prestaciones pre on pre.id = r.id_prestacion
        join efectores.efectores e on e.cuie = pre.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        join geo.provincias pro on pro.id_provincia = dg.id_provincia
        where pre.codigo_prestacion in ('APA002X76')
        group by pro.id_provincia, pre.codigo_prestacion";
    }

    public function dr10()
    {
        $query = "select pro.id_provincia, pre.codigo_prestacion
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        where ausentes->'ids' ?& array['10']
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia) as \"10-ausentes\"
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        where errores->'ids' ?& array['10']
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia) as \"10-errores\"
        from logs.revision r
        join prestaciones.prestaciones pre on pre.id = r.id_prestacion
        join efectores.efectores e on e.cuie = pre.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        join geo.provincias pro on pro.id_provincia = dg.id_provincia
        where pre.codigo_prestacion in ('APA002A98','APA002X75','APA002X80')
        group by pro.id_provincia, pre.codigo_prestacion";
    }

    public function dr14()
    {
        $query = "select pro.id_provincia, pre.codigo_prestacion
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        where ausentes->'ids' ?& array['14']
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia) as \"14-ausentes\"
        ,(select count(*)
        from logs.revision r
        join prestaciones.prestaciones p on p.id = r.id_prestacion
        join efectores.efectores e on e.cuie = p.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        where errores->'ids' ?& array['14']
        and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
        and p.codigo_prestacion = pre.codigo_prestacion
        and dg.id_provincia = pro.id_provincia) as \"14-errores\"
        from logs.revision r
        join prestaciones.prestaciones pre on pre.id = r.id_prestacion
        join efectores.efectores e on e.cuie = pre.efector
        join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
        join geo.provincias pro on pro.id_provincia = dg.id_provincia
        where pre.codigo_prestacion = 'NTN002X75'
        group by pro.id_provincia, pre.codigo_prestacion";
    }
}
