<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class QueryToCsv extends Command
{
    private $lotes = [8906,8995,8924,8896,8914,9040,9037,9003,8949,8927,8926,8909,8942,8962,9053,8983,8985,9009,
        9010,9011,9047,9048,9049,9050,9051,9052,8975,8978,8979,8982,8952,8901,9035,8923,8959,8919,8904,8903,8974,8981,
        8935];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:queries-csv
    {--l|lote= : Número de lote}
    {--d|dr= : Número de dr}';

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
	//Para testear voy a hacer un count

        $this->req();

        //Por ultimo trae a la carpeta csv el archivo
    }

    public function req()
    {
        //$dr = $this->option('dr');
        $filename = '3-validos.csv';
        $craft = "Copy (".$this->oriana().
        // ") To '/tmp/medica/{$dr}.csv' With CSV HEADER DELIMITER ';';";
        ") To '/tmp/{$filename}' With CSV HEADER DELIMITER ';';";

        DB::statement($craft);
        $this->info($filename." created succesfully.");
    }

    //La query cambia para los que necesitan distintos ids segun grupo etario

    public function oriana()
    {
        return "select geo.descripcion as provincia, count(*) "
        ."from logs.revision r "
        ."join prestaciones.prestaciones p on p.id = r.id_prestacion "
        ."join efectores.efectores e on e.cuie = p.efector "
        ."join efectores.datos_geograficos dg on dg.id_efector = e.id_efector "
        ."join geo.provincias geo on geo.id_provincia = dg.id_provincia "
        .$this->porGrupoEtario()
        ."where p.fecha_prestacion between '2017-01-01' and '2017-06-30' "
        .$this->codigos3()
        // .$this->validos()
        // .$this->algunDato()
        ."group by geo.id_provincia, geo.descripcion "
        ."order by geo.id_provincia"
        ;
    }

    public function algunDato()
    {
        return "and (r.errores is not null or r.errores is null and r.ausentes is null and validos is not null) ";
    }

    public function validos()
    {
        return "and r.errores is null and r.ausentes is null and validos is not null ";
    }

    public function porGrupoEtario()
    {
        return "join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario "
        ."join prestaciones.grupos_etarios ge on age(p.fecha_prestacion, b.fecha_nacimiento) between "
        ."ge.edad_min::interval and ge.edad_max::interval ";
    }

    public function codigos1()
    {
        return "and p.codigo_prestacion in ('CTC005W78', 'CTC006W78' ,'CTC007O24.4', 'CTC022O24.4','CTC007O10','CTC007O10.4','CTC022O10','CTC022O10.4','CTC007O16','CTC022O16','CTC017P05') ";
    }

    public function codigos2()
    {
        return "and p.codigo_prestacion = 'CTC001A97' and ge.id_grupo_etario = 1 ";
    }

    public function codigos3()
    {
        return "and p.codigo_prestacion in ('CTC001A97', 'CTC009A97') and ge.id_grupo_etario = 3 ";
    }

    public function codigos4()
    {
        return "and p.codigo_prestacion in ('APA002A98', 'APA002X75', 'APA002X80', 'APA002X76') ";
    }

    public function codigos5()
    {
        return "and p.codigo_prestacion in ('CTC001T79','CTC001T82', 'CTC002T79' ,'CTC002T82', 'CTC001T83', 'CTC002T83', 'CTC001T79','CTC001T82','CTC002T79','CTC002T82','CTC001T83','CTC002T83') ";
    }

    public function copyCsv()
    {
        $lote = $this->option('lote');

        $craft = "Copy (select i.*,g.descripcion as grupo_etario
            from prestaciones.informeDR i
            join prestaciones.grupos_etarios g on i.edad::interval between edad_min::interval and edad_max::interval
            where i.lote = {$lote}
            order by provincia) To '/tmp/2017/dr-medica-octubre/{$lote}.csv' With CSV HEADER DELIMITER ';';";

            DB::statement($craft);
        }

        public function another($value = '')
        {
            $lote = $this->option('lote');

            $resultado = DB::select("select p.id from prestaciones.requiere_datos_reportables rd
                join prestaciones.prestaciones_completo p on p.codigo_prestacion = rd.codigo_prestacion
                where p.lote = {$lote}");
            $resultado = array_map(function ($v) {
                return $v->id;
            }, $resultado);
            $this->line(json_encode($resultado));
        }

        public function dr8()
        {
            return $query = "select pro.id_provincia, pre.codigo_prestacion
            ,(select count(*)
            from logs.revision r
            join prestaciones.prestaciones p on p.id = r.id_prestacion
            join efectores.efectores e on e.cuie = p.efector
            join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
            where ausentes->'ids' ?& array['8']
            and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
            and p.codigo_prestacion = pre.codigo_prestacion
            and dg.id_provincia = pro.id_provincia) as \"8-ausentes\"
            ,(select count(*)
            from logs.revision r
            join prestaciones.prestaciones p on p.id = r.id_prestacion
            join efectores.efectores e on e.cuie = p.efector
            join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
            where errores->'ids' ?& array['8']
            and p.fecha_prestacion between ('2017-01-01') and ('2017-06-30')
            and p.codigo_prestacion = pre.codigo_prestacion
            and dg.id_provincia = pro.id_provincia) as \"8-errores\"
            from logs.revision r
            join prestaciones.prestaciones pre on pre.id = r.id_prestacion
            join efectores.efectores e on e.cuie = pre.efector
            join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
            join geo.provincias pro on pro.id_provincia = dg.id_provincia
            where pre.codigo_prestacion in ('PRP017A46','PRP017A97')
            group by pro.id_provincia, pre.codigo_prestacion";
        }

        public function grupoDeCodigos()
        {
            return [
                "and p.codigo_prestacion in ('CTC005W78', 'CTC006W78' ,'CTC007O24.4', CTC022O24.4','CTC007O10','CTC007O10.4','CTC022O10','CTC022O10.4',
                'CTC007O16','CTC022O16','CTC017P05') ",
                "and p.codigo_prestacion = 'CTC001A97' and ge.id_grupo_etario = 1 ",
                "and p.codigo_prestacion in ('CTC001A97', 'CTC009A97') and ge.id_grupo_etario = 3 ",
                "and p.codigo_prestacion in ('APA002A98', 'APA002X75', 'APA002X80', 'APA002X76') ",
                "and p.codigo_prestacion in ('CTC001T79','CTC001T82', 'CTC002T79' ,'CTC002T82', 'CTC001T83', 'CTC002T83', 'CTC001T79','CTC001T82','CTC002T79','CTC002T82','CTC001T83','CTC002T83') "
            ];
        }        

        public function dwInforme()
        {
        /*
        de cada grupo etario y combinacion de prestaciones se hace despues de haber hecho el analisis de los datos 
        reportables un informe donde se calculan totale presentados por periodo, provincia y codigo de prestacion 
        segun grupo etario si corresponde
        */

        $grupoDeCodigos = [
            "and p.codigo_prestacion in ('CTC001A97', 'CTC009A97') and ge.id_grupo_etario = 3 "
        ];

        /*
        Para todos los grupos de codigos
        */
        foreach ($grupoDeCodigos as $codigos) {
            DB::statement(
                "select cast(regexp_replace(p.fecha_prestacion::text,'(\d+)-(\d+)-\d+','\1\2') as integer) as periodo,
                dg.id_provincia as provincia,
                p.codigo_prestacion,
                ge.id_grupo_etario,
                count(*) as presentados,
                0 as algun_dato,
                0 as todos_los_datos,
                0 as algun_dato_valido,
                0 as todos_los_datos_validos
                into temporales.informe_datos_reportables
                from logs.revision r 
                join prestaciones.prestaciones p on p.id = r.id_prestacion
                join efectores.efectores e on e.cuie = p.efector
                join efectores.datos_geograficos dg on dg.id_efector = e.id_efector
                join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario
                join prestaciones.grupos_etarios ge on age(p.fecha_prestacion, b.fecha_nacimiento)
                between ge.edad_min::interval and ge.edad_max::interval 
                where p.fecha_prestacion between '2017-01-01' and '2017-06-30'"
                .$codigos
                ."group by cast(regexp_replace(p.fecha_prestacion::text,'(\d+)-(\d+)-\d+','\1\2') as integer),
                dg.id_provincia,
                ge.id_grupo_etario,
                p.codigo_prestacion"
            );

            $counts = [
                [
                    'columna' => 'algun_dato ',
                    'condicion' => 'and (r.errores is not null or r.validos is not null) '
                ],
                [
                    'columna' => 'todos_los_datos ',
                    // 'condicion' => 'and r.ausentes is null and (not(r.errores is null and r.validos is null)) '
                    'condicion' => 'and r.ausentes is null '
                ],
                [
                    'columna' => 'algun_dato_valido ',
                    'condicion' => 'and r.validos is not null '
                ],
                [
                    'columna' => 'todos_los_datos_validos ',
                    'condicion' => 'and r.errores is null and r.ausentes is null and validos is not null '
                ],
            ];

            foreach ($counts as $count) {
                DB::statement("
                    update temporales.informe_datos_reportables
                    set "
                    .$count['columna']
                    ." = sub.cantidad from(
                        select cast(regexp_replace('2017-01-01', '(\d+)-(\d+)-\d+', '\1\2') as integer) as s_periodo,
                        dg.id_provincia as s_provincia,
                        p.codigo_prestacion as s_codigo_prestacion,
                        ge.id_grupo_etario as s_id_grupo_etario,
                        count(*) as cantidad
                        from logs.revision r join prestaciones.prestaciones p on p.id = r.id_prestacion join efectores.efectores e on e.cuie = p.efector join efectores.datos_geograficos dg on dg.id_efector = e.id_efector join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario join prestaciones.grupos_etarios ge on age(p.fecha_prestacion, b.fecha_nacimiento) between ge.edad_min::interval and ge.edad_max::interval 
                        where p.fecha_prestacion between '2017-01-01' and '2017-06-30'"
                        .$codigos
                        .$count['condicion']
                        ."group by cast(regexp_replace('2017-01-01', '(\d+)-(\d+)-\d+', '\1\2') as integer),
                        dg.id_provincia,
                        ge.id_grupo_etario,
                        p.codigo_prestacion
                    ) as sub
                    where periodo = s_periodo and provincia = s_provincia and codigo_prestacion = s_codigo_prestacion and id_grupo_etario = s_id_grupo_etario
                    ");
            }
        }

        //Se hace un update para contar cuantos tuvieron al menos un dato presentado erroneo o valido

        //Se hace un update para contar cuantos tuvieron todos los datos presentados erroneos o validos

        //Tuvieron algun dato valido

        //Tuvieron todos los datos validos
    }
}
