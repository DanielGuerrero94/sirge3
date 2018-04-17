<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class RunQuery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:query';

    /**
     * The console comm:and description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $queries = $this->queries();

        foreach ($queries as $query) {
            $craft = "Copy (select p.codigo_prestacion,p.fecha_prestacion,b.clave_beneficiario,ge.descripcion,b.sexo from prestaciones.prestaciones p 
                left join sistema.lotes l on p.lote = l.lote
                join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario,
                temporales.grupos_etarios_gosis ge 
                where p.estado = 'L'::bpchar and l.id_estado = 3
                and p.fecha_prestacion between '2016-01-01' and '2016-12-31' and (";

            if (array_key_exists('prestaciones', $query)) {
                $craft .= "p.codigo_prestacion in({$query['prestaciones']})";
            }

            if (array_key_exists('like', $query)) {
                $first = array_shift($query['like']);
                if (array_key_exists('prestaciones', $query)) {
                    $craft .= " or ";
                }
                $craft .= " p.codigo_prestacion like '{$first}'";
                foreach ($query['like'] as $like) {
                    $craft .= " or p.codigo_prestacion like '{$like}'";
                }
            }

                $craft .= " )";

                $craft .= " and age(p.fecha_prestacion,b.fecha_nacimiento) between ge.edad_min and ge.edad_max order by p.codigo_prestacion,p.fecha_prestacion) To '/tmp/2016/{$query['nombre']}.csv' With CSV HEADER DELIMITER ';';";

                $start = date("H:i:s");
                $success = DB::statement($craft);


            if ($success) {
                $this->info('Executed '.$query['nombre']);
            } else {
                $this->error('Executing '.$query['nombre']);
            }
        }
    }

    public function queries()
    {
        return [
        [
            'nombre' => '4-Tétano',
            'prestaciones' => "'IMV006A98','IMV008A98','IMV010A98','IMV003A98','IMV004A98'",
        ],
        ];
    }

    public function finalizadas()
    {
        return [
        [
            'nombre' => '1-Tuberculosis',
            'prestaciones' => "'IMV012A98'",
        ],
        [
            'nombre' => '2-HIV SIDA',
            'prestaciones' => "'ITE002A42','CTC007B90'",
        ],
        [
            'nombre' => '3-Enfermedad diarreica',
            'prestaciones' => "'CTC001D11','CTC002D11','ITE001D11'",
        ],
        [
            'nombre' => '4-Tétano',
            'prestaciones' => "'IMV006A98','IMV008A98'",
        ],
        [
            'nombre' => '5-Rubeola',
            'prestaciones' => "'IMV001A98','IMV011A98'",
        ],
        [
            'nombre' => '6-Varicela y Herpes zoster',
            'prestaciones' => "'IMV017A98'",
        ],
        [
            'nombre' => '7-Infecciones respiratorias bajas',
            'prestaciones' => "'ITE003R81','ITE001R78'",
        ],
        [
            'nombre' => '8-Fiebre amarilla',
            'prestaciones' => "'IMV007A98'",
        ],
        [
            'nombre' => '9-Enfermedad de Chagas',
            'prestaciones' => "'ITE002A40'",
        ],
        [
            'nombre' => '10-Hemorragia materna anteparto, intraparto y post parto',
            'prestaciones' => "'CTC007W06'",
            'like' => ['ITE004%','ITQ005%','ITE005%','ITQ006%','ITE006%','ITQ007%','ITQ008%','ITQ004%',],
        ],
        [
            'nombre' => '11-Trastorns hipertensivos maternos',
            'prestaciones' => "'CTC007O10.0','CTC007O10.4','CTC022O10.0','CTC022O10.4','CTC007O16','CTC022O16'",
            'like' => [
                'ITE007%','ITE011%',
            ],
        ],
        [
            'nombre' => '12-Aborto, parto prematuro y embarazo ectópico',
            'prestaciones' => "'COT018A98'",
            'like' => [
                'ITE008%',
            ],
        ],
        [
            'nombre' => '13-Malnutrición proteico calórica',
            'prestaciones' => "'CTC029T94','CTC029T95','CTC031T94','CTC031T95','CTC001T91','CTC002T91'",
        ],
        [
            'nombre' => '14-Anemia ferropenica',
            'prestaciones' => "'CTC001B80','CTC002B80','CTC007B80','CTC005B80'",
        ],
        [
            'nombre' => '15-Sífilis',
            'prestaciones' => "'ITE002A41','CTC007X70'",
        ],
        [
            'nombre' => '16-Gonococcia',
            'prestaciones' => "'CTC007X71'",
        ],
        [
            'nombre' => '17-Clamydiasis',
            'prestaciones' => "'CTC007X92'",
        ],
        [
            'nombre' => '18-Hepatitis aguda A',
            'like' => [
                'IMV005%',
            ],
        ],
        [
            'nombre' => '19-Hepatitis B',
            'like' => [
                'IMV009%',
            ],
        ],
        [
            'nombre' => '20-Hepatitis C',
            'like' => [
                'LBL123%',
            ],
        ],
        [
            'nombre' => '21-cancer de mama',
            'prestaciones' => "'CTC001X76','CTC001X30','CTC001X19','CTC002X76','CTC002X30','CTC002X19','APA002X76','APA002X79'",
            'like' => [
                'IGR014%',
            ],
        ],
        [
            'nombre' => '22-cancer de cuello',
            'prestaciones' => "'CTC001X75','CTC002X75','PRP018A98','APA001A98','APA001X86','APA001X75','PRP037A98','APA004A97','APA004A77','APA002A98','APA002X75','APA002X80'",
        ],
        [
            'nombre' => '23-Linfoma de Hodgkin',
            'prestaciones' => "'CTC001B72'",
        ],
        [
            'nombre' => '24-Leucemia',
            'prestaciones' => "'CTC001B73'",
        ],
        [
            'nombre' => '25-Cáncer de colon y recto',
            'prestaciones' => "'APA002D75','APA002D94','APA002D78'",
            'like' => [
                'IGR049%','IGR048%','LBL098%',
            ],
        ],
        [
            'nombre' => '26-Afecciones cardiovasculares',
            'prestaciones' => "'CTC048K22','NTN007K22','NTN008K22','NTN009K22','CTC049K22'",
        ],
        [
            'nombre' => '27-úlcer péptica',
            'like' => [
                'IGR012%',
            ],
        ],
        [
            'nombre' => '28-Defectos del tubo neural',
            'prestaciones' => "'ITQ013Q05'",
        ],
        [
            'nombre' => '29-Cardiopatías congénitas',
            'like' => [
                'CTC040%','ITK001%','ITK002%','ITK003%','ITK004%','ITK005%','ITK006%','ITK007%','ITK008%','ITK009%','ITK0010%','ITK0011%','ITK0012%','ITK0013%','ITK0014%','ITK0015%','ITK0016%','ITK0017%','ITK0018%','ITK0019','ITK0020%','ITK0021%','ITK0022%','ITK0023%','ITK0024%','ITK0025%','ITK0026%','ITK0027%','ITK0028%','ITK0029%','ITK0030%','ITK0031%','ITK0032%','ITK0033%','ITK0034%','ITK0035%','ITK0036%','ITK0037%','ITK0038%','ITK0039%','ITK0040%','ITK0041%','ITK0042%','ITK0043%','ITK0044%','ITK0045%','ITK0046%','ITK200%','ITK201%',
            ],
        ],
        [
            'nombre' => '30-Queilopalatosquisis',
            'like' => [
                'PRP036%','CTC034%','PRP038%',
            ],
        ],
        [
            'nombre' => '31-Hipoacusia debida a la edad y otras hipoacusias',
            'prestaciones' => "'CTC001H86'",
            'like' => [
                'PRP021%',
            ],
        ],
        [
            'nombre' => '32-Caries en dientes temporales',
            'prestaciones' => "'PRP025A98','CTC010A97','PRP026D60'",
        ],
        [
            'nombre' => '33-Caries en dientes permanentes',
            'prestaciones' => "'PRP025A98','CTC010A97','CTC010W78','PRP026D60','PRP024A98'",
        ],
        [
            'nombre' => '34-Enfermedades periodontales',
            'prestaciones' => "'CTC010D61'",
        ],
        [
            'nombre' => '35-Asma',
            'prestaciones' => "'CTC001R96','CTC012R96'",
        ],
        [
            'nombre' => '36-Trastornos por consumo de alcohol',
            'prestaciones' => "'CTC012P20','CTC001P20','CTC002P20'",
        ],
        [
            'nombre' => '37-Trastornos por consumo de drogas psicoatcivas',
            'prestaciones' => "'CTC012P24','CTC001P24','CTC002P24'",
        ],
        [
            'nombre' => '38-Diabetes mellitus',
            'prestaciones' => "'ITE010O24.4'",
            'like' => [
                'LBL056%','CTC051%','CTC050%',
            ],
        ],
        [
            'nombre' => '38b-Diabetes mellitus',
            'prestaciones' => "'ITE009O24.4'",
        ],
        [
            'nombre' => '39-Enfermedad renal crónica',
            'prestaciones' => "'PRP025A98','CTC010A97','CTC010W78','PRP026D60','PRP024A98'",
            'like' => [
                'CTC047%','CTC045%',
            ],
        ],
        [
            'nombre' => '40-Infertilidad femenina',
            'prestaciones' => "'NTN020W15'",
            'like' => [
                'CTC043%',
            ],
        ],
        [
            'nombre' => '41-Lesiones autoinfligidas',
            'prestaciones' => "'CTC001P98','CTC012P98'",
        ],
        [
            'nombre' => '42-Violencia interpersonal',
            'prestaciones' => "'CTC012Z31'",
        ],
        [
            'nombre' => '43-Meningitis meningocóccica',
            'prestaciones' => "'IMV019A98'",
        ],
        ];
    }
}
