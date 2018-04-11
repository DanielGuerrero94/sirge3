<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class DwDrCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dw:dr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Datawarehouse datos reportabls';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
        de cada grupo etario y combinacion de prestaciones se hace despues de haber hecho el analisis de los datos 
        reportables un informe donde se calculan totale presentados por periodo, provincia y codigo de prestacion 
        segun grupo etario si corresponde
        */
        

        $grupoDeCodigos = [
            /*[
                'grupo_etario' => false,
                'condicion' => "and p.codigo_prestacion in ('CTC005W78', 'CTC006W78' ,'CTC007O24.4', 'CTC022O24.4','CTC007O10','CTC007O10.4','CTC022O10','CTC022O10.4',
                'CTC007O16','CTC022O16','CTC017P05') "
            ],
            [
                'grupo_etario' => false,
                'condicion' => "and p.codigo_prestacion in ('APA002A98', 'APA002X75', 'APA002X80', 'APA002X76') "
            ],
            */
            [
                'grupo_etario' => true,
                'condicion' => "and p.codigo_prestacion in ('CTC001T79','CTC001T82', 'CTC002T79' ,'CTC002T82', 'CTC001T83', 'CTC002T83', 'CTC001T79','CTC001T82','CTC002T79','CTC002T82','CTC001T83','CTC002T83') and (ge.id_grupo_etario = 11 or ge.id_grupo_etario = 12) "
            ],
            [
                'grupo_etario' => true,
                'condicion' => "and p.codigo_prestacion in ('CTC001A97', 'CTC009A97') and (ge.id_grupo_etario = 11 or ge.id_grupo_etario = 12) "
            ]
            /*,
            [
                'grupo_etario' => true,
                'condicion' => "and p.codigo_prestacion = 'CTC001A97' and ge.id_grupo_etario = 1 "
            ]*/
        ];

        $counts = [
            [
                'columna' => 'algun_dato ',
                'condicion' => 'and (r.errores is not null or r.validos is not null) '
            ],
            [
                'columna' => 'todos_los_datos ',
                'condicion' => 'and r.ausentes is null '
            ],
            [
                'columna' => 'algun_dato_valido ',
                'condicion' => 'and r.validos is not null '
            ],
            [
                'columna' => 'todos_los_datos_validos ',
                'condicion' => 'and r.errores is null and r.ausentes is null and validos is not null '
            ]
        ];

        /*
        Para todos los grupos de codigos
        */
        foreach ($grupoDeCodigos as $codigos) {
            $now = Carbon::now();
            $this->info("Calculando ".$codigos['condicion']);
            /*DB::statement(
                "select cast(regexp_replace(p.fecha_prestacion::text,'(\d+)-(\d+)-\d+','\\1\\2') as integer) as periodo,
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
                ."group by cast(regexp_replace(p.fecha_prestacion::text,'(\d+)-(\d+)-\d+','\\1\\2') as integer),
                dg.id_provincia,
                ge.id_grupo_etario,
                p.codigo_prestacion"
            );*/

            /*
            Todos los codigos de prestacion que requieren datos reportables estan divididos segun grupo etario 
            pero no todos necesitan verificacion haciendo join
            */

            $query =
            "insert into temporales.informe_datos_reportables
            (select cast(regexp_replace(p.fecha_prestacion::text,'(\d+)-(\d+)-\d+','\\1\\2') as integer) as periodo,
            dg.id_provincia as provincia,
            p.codigo_prestacion,";

            $query .= $codigos['grupo_etario']?"ge.id_grupo_etario,":"0 as id_grupo_etario,";
            
            $query .=
            "count(*) as presentados,
            0 as algun_dato,
            0 as todos_los_datos,
            0 as algun_dato_valido,
            0 as todos_los_datos_validos
            from logs.revision r 
            join prestaciones.prestaciones p on p.id = r.id_prestacion
            join efectores.efectores e on e.cuie = p.efector
            join efectores.datos_geograficos dg on dg.id_efector = e.id_efector ";

            $query .= $codigos['grupo_etario']?"join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario
            join prestaciones.grupos_etarios ge on age(p.fecha_prestacion, b.fecha_nacimiento)
            between ge.edad_min::interval and ge.edad_max::interval ":"";

            $query .= "where p.fecha_prestacion between '2017-01-01' and '2017-06-30'"
            .$codigos['condicion']
            ."group by cast(regexp_replace(p.fecha_prestacion::text,'(\d+)-(\d+)-\d+','\\1\\2') as integer),
            dg.id_provincia,";

            $query .= $codigos['grupo_etario']?"ge.id_grupo_etario,":"";

            $query .= "p.codigo_prestacion)";

            DB::statement($query);

            foreach ($counts as $count) {
                $now2 = Carbon::now();
                $this->info("Calculando ".$count['columna']);

                $query_update = "update temporales.informe_datos_reportables set ";
                $query_update .= $count['columna'];
                $query_update .=  " = sub.cantidad from(
                    select cast(regexp_replace(p.fecha_prestacion::text, '(\d+)-(\d+)-\d+', '\\1\\2') as integer) as s_periodo,
                    dg.id_provincia as s_provincia,
                    p.codigo_prestacion as s_codigo_prestacion,";

                $query_update .=  $codigos['grupo_etario']?"ge.id_grupo_etario as s_id_grupo_etario,":"";

                $query_update .=  "count(*) as cantidad
                    from logs.revision r join prestaciones.prestaciones p on p.id = r.id_prestacion join efectores.efectores e on e.cuie = p.efector join efectores.datos_geograficos dg on dg.id_efector = e.id_efector ";

                $query_update .= $codigos['grupo_etario']?"join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario join prestaciones.grupos_etarios ge on age(p.fecha_prestacion, b.fecha_nacimiento) between ge.edad_min::interval and ge.edad_max::interval ":"";

                $query_update .= "where p.fecha_prestacion between '2017-01-01' and '2017-06-30'";
                $query_update .= $codigos['condicion'];
                $query_update .= $count['condicion'];
                $query_update .= "group by cast(regexp_replace(p.fecha_prestacion::text, '(\d+)-(\d+)-\d+', '\\1\\2') as integer),
                    dg.id_provincia,";

                $query_update .= $codigos['grupo_etario']?"ge.id_grupo_etario,":"";

                $query_update .= "p.codigo_prestacion) as sub where periodo = s_periodo and provincia = s_provincia and codigo_prestacion = s_codigo_prestacion ";

                $query_update .= $codigos['grupo_etario']?"and id_grupo_etario = s_id_grupo_etario":"";

                DB::statement($query_update);

                $this->info("Tardo ".$now2->diffInSeconds(Carbon::now()));
            }
            $this->info("Tardo ".$now->diffInSeconds(Carbon::now()));
        }
    }
}
