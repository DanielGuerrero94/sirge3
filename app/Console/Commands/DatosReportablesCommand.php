<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lote;
use App\Http\Controllers\PrestacionesDRController;
use App\Http\Controllers\PrestacionesController;
use DB;
use App\Models\RechazoDR;
use App\Models\Prestacion;
use App\Models\Dw\DR\RevisionPrestacion;

class DatosReportablesCommand extends Command
{
    private $_data = [
        'operacion',
        'estado',
        'numero_comprobante',
        'codigo_prestacion',
        'subcodigo_prestacion',
        'precio_unitario',
        'fecha_prestacion',
        'clave_beneficiario',
        'tipo_documento',
        'clase_documento',
        'numero_documento',
        'orden',
        'efector',
        'lote',
        'datos_reportables'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:datos-reportables
    {--l|lote= : Número de lote}    
    {--p|provincia= : Provincia - si no especifica fecha busca el ultimo lote aceptado}
    {--mes= : Mes - si no especifica provincia busca todos los lotes aceptados de ese mes}
    {--progress : Muestra progreso}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consigue los datos reportables del ultimo lote procesado y aceptado';

    public function handle()
    {
        $lote = $this->option('lote');
        info("Buscando prestaciones con codigo que requiera dato reportable...");
        $ids_prestaciones = DB::select("select p.id
            from prestaciones.prestaciones p 
            join sistema.lotes l using(lote)
            join prestaciones.requiere_datos_reportables r on r.codigo_prestacion = p.codigo_prestacion
            where 
            l.id_estado = 3
            and p.estado = 'L'
            and l.lote = {$lote}");

        $ids_prestaciones = array_map(function ($v) {
            return $v->id;
        }, $ids_prestaciones);

        $count = count($ids_prestaciones);
        info("El lote {$lote} tiene {$count} que se van a revisar.");
        foreach ($ids_prestaciones as $id_prestacion) {
            $prestacion = Prestacion::findOrFail($id_prestacion)->toArray();
            $resultado = (new PrestacionesDRController())->verificar($prestacion);

            if (!$resultado['success']) {
                if (array_key_exists('null', $resultado)) {
                    $ausentes = [
                        'ids' => $this->mapearMotivos($resultado['ids'])
                    ];
                } elseif (array_key_exists('wrong', $resultado)) {
                    $ids_ausentes = array_diff($resultado['requiere'], $resultado['tiene']);
                    $ausentes = [
                        'ids' => $this->mapearMotivos(array_values($ids_ausentes))
                    ];
                    if (!empty($resultado['tiene'])) {
                        $validos = [
                            'ids' => $this->mapearMotivos($resultado['tiene'])
                        ];
                    }
                } elseif (array_key_exists('errores', $resultado)) {
                    $errores = [
                        'ids' => $this->mapearMotivos($resultado['errores'])
                    ];
                    if (!empty($resultado['validados'])) {
                        $validos = [
                            'ids' => $this->mapearMotivos($resultado['validados'])
                        ];
                    }
                } else {
		    info("DOIU 32: ".json_encode($prestacion));
		    continue;
		}
            } elseif (array_key_exists('tiene', $resultado)) {
                    $validos = [
                        'ids' => $this->mapearMotivos($resultado['tiene'])
                    ];
            }

            $id_prestacion = $prestacion['id'];
	    $validos = isset($validos)?json_encode($validos):null;
	    $ausentes = isset($ausentes)?json_encode($ausentes):null;
	    $errores = isset($errores)?json_encode($errores):null;
            RevisionPrestacion::create(compact('id_prestacion', 'lote', 'validos', 'ausentes', 'errores'));
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function asdhandle()
    {
        $lote;
        $start = date("Y-m-d H:i:s");
        if ($this->option('lote')) {
            $lote = Lote::with(['archivo'])
            ->find($this->option('lote'));
        } else {
            $this->comment('No se especifico número de lote.');
            //Consigue el ultimo lote de prestaciones aceptado sin importar provincia
            $lote = Lote::whereHas('archivo', function ($query) {
                $query->where('id_padron', 1);
            })
            ->with('archivo')
            ->where('id_estado', 3)
            ->whereNotNull('fin')
            ->latest('fin')
            ->select('lote', 'id_provincia', 'fin', 'id_subida');

            if ($this->option('provincia')) {
                var_dump($this->option('provincia'));
                $this->comment('Se especifico la provincia.');
                $lote = $lote->where('id_provincia', $this->option('provincia'));
            }

            if ($this->option('mes')) {
                $this->comment('Se especifico el mes.');
                var_dump($this->option('mes'));
            }

            $lote = $lote->first();
        }

        $filename = $lote->archivo->nombre_actual;
        $filepath = env('APP_PATH').$filename;

        if (!file_exists($filepath)) {
            $this->call('get:file', ['name' => $filename]);
        }

        $f = fopen($filepath, 'r');
        $word_count = system("wc -l {$filepath}");
        preg_match('/\d+/', $word_count, $cantidad);
        $cantidad = intval($cantidad[0]);

        $header = fgets($f);
        unset($header);

        $dr = new PrestacionesDRController();
        $validas = 0;
        $invalidas = 0;
        $noRequiere = 0;
        $sinDatosReportables = 0;
        $fueraDeRangos = 0;

        $progress = $this->output->createProgressBar($cantidad);
        $progress->setRedrawFrequency(100);

        $prestacionesController = new PrestacionesController();
        while ($string = fgets($f)) {
            $linea = explode(';', trim($string, "\r\n"));

            $prestacion = $prestacionesController->armarArray($linea, $lote->lote);
            $prestacion = array_combine($this->_data, $prestacion);

            $resultado = $dr->verificar($prestacion);
            $progress->clear();
            $this->info(json_encode($prestacion));

            if ($resultado['success']) {
                if (array_key_exists('skip', $resultado)) {
                    $noRequiere++;
                } else {
                    $validas++;
                }
                $this->info($resultado['message']);
            } else {
                if (array_key_exists('null', $resultado)) {
                    $sinDatosReportables++;
                } elseif (array_key_exists('wrong', $resultado)) {
                    $invalidas++;
                } else {
                    $fueraDeRangos++;
                }
                $this->error($resultado['errors']);

                RechazoDR::create([
                    'lote' => $lote->lote,
                    'registro' => json_encode($prestacion),
                    'motivos' => json_encode($resultado['errors'])
                ]);
            }
            $progress->setFormat("Progress: <info>%percent%</info>\033[32m%\033[0m <fg=white;bg=blue>%remaining%</> "
                ."Vacio: <error>{$sinDatosReportables}</error> Correctos:<info>{$validas}</info> Incorrecto: <error>"
                ."{$fueraDeRangos}</error> Ids invalidas: <error>{$invalidas}</error>");
            $progress->display();
            $progress->advance();
        }

        $resultados = [
            'lote' => $lote->lote,
            'sin' => $sinDatosReportables,
            'ids_incorrectos' => $invalidas,
            'rangos_incorrectos' => $fueraDeRangos,
            'rangos_correctos' => $validas,
            'started_at' => $start,
            'ended_at' => date("Y-m-d H:i:s"),
        ];

        $this->info("Se validaron {$cantidad} prestaciones");
        $this->info("No requiere datos reportables: {$noRequiere}");
        $this->table(array_keys($resultados), array_values($resultados));

        DB::table('logs.resultadosDR')->insert($resultados);
        $progress->finish();
    }

    public function handleOld()
    {
        $lote;
        $start = date("Y-m-d H:i:s");
        if ($this->option('lote')) {
            $lote = Lote::with(['archivo'])
            ->find($this->option('lote'));
        } else {
            $this->comment('No se especifico número de lote.');
            //Consigue el ultimo lote de prestaciones aceptado sin importar provincia
            $lote = Lote::whereHas('archivo', function ($query) {
                $query->where('id_padron', 1);
            })
            ->with('archivo')
            ->where('id_estado', 3)
            ->whereNotNull('fin')
            ->latest('fin')
            ->select('lote', 'id_provincia', 'fin', 'id_subida');

            if ($this->option('provincia')) {
                var_dump($this->option('provincia'));
                $this->comment('Se especifico la provincia.');
                $lote = $lote->where('id_provincia', $this->option('provincia'));
            }

            if ($this->option('mes')) {
                $this->comment('Se especifico el mes.');
                var_dump($this->option('mes'));
            }

            $lote = $lote->first();
        }

        /*$ids_prestaciones = Prestacion::select('id')
        ->where('lote', $lote->lote)
        ->get('id')
        ->map(function ($v) {
            return $v->id;
        }) ;*/

        $this->info("Busca prestaciones del lote.");

        /*$ids_prestaciones = Prestacion::select('id')
        ->where('lote', $lote->lote)
        ->where('estado', 'L')
        ->whereRaw("codigo_prestacion in (
            'CTC005W78',
            'PRP021A97',
            'PRP021H86',
            'PRP017A46',
            'PRP017A97',
            'CTC001A97',
            'CTC009A97',
            'APA002X76',
            'APA002A98',
            'APA002X75',
            'APA002X80',
            'APA002X76',
            'LBL119A97',
            'LBL119W78',
            'NTN002X75',
            'CTC010W78',
            'CTC010A97',
            'CTC001T79',
            'CTC001T82',
            'CTC001T83',
            'CTC002T79',
            'CTC002T82',
            'CTC002T83',
            'IGR014A98')")
        ->get('id')
        ->map(function ($v) {
            return $v->id;
        }) ;*/

        /*$ids_prestaciones = Prestacion::select('id')
        ->where('lote', $lote->lote)
        ->where('estado', 'L')
        ->whereRaw("codigo_prestacion in (
            'CTC005W78',
            'PRP021A97',
            'PRP021H86',
            'PRP017A46',
            'PRP017A97',
            'CTC001A97',
            'CTC009A97',
            'APA002X76',
            'APA002A98',
            'APA002X75',
            'APA002X80',
            'APA002X76',
            'LBL119A97',
            'LBL119W78',
            'NTN002X75',
            'CTC010W78',
            'CTC010A97',
            'CTC001T79',
            'CTC001T82',
            'CTC001T83',
            'CTC002T79',
            'CTC002T82',
            'CTC002T83',
            'IGR014A98')")
        ->get('id')
        ->map(function ($v) {
            return $v->id;
        });*/

        $ids_prestaciones = Prestacion::select('id')
        ->where('lote', $lote->lote)
        ->where('estado', 'L')
        ->get('id')
        ->map(function ($v) {
            return $v->id;
        });

        $cantidad = count($ids_prestaciones);
        $this->info("Cantidad de prestaciones: ".$cantidad);

        $dr = new PrestacionesDRController();
        $validas = 0;
        $invalidas = 0;
        $noRequiere = 0;
        $sinDatosReportables = 0;
        $fueraDeRangos = 0;
        $nombres_ids_datos_reportables = ['Peso', 'Talla', 'Toma de TA', 'Perímetro cefálico',
        'Registro de edad gestacional', 'Índice CPOD y/o ceod  según corresponda',
        'Resultado OEA en Oído derecho/ Oído izquierdo',
        'Resulado grado de retinopatía',
        'Informe o transcripción de estudios solicitados 
        (Prestación: Anatomía patológica de biopsia (CA mama) )',
        'Informe o transcripción de estudios solicitados (Prestación:
           Diagnóstico por biopsia en laboratorio de anatomía patológica,
           para aquellas mujeres con citología ASC-H, H-SIL,Cáncer (CA cervicouterino))',
           'Informe o transcripción de estudios solicitados
           (Prestación: Lectura de la muestra tomada en mujeres entre 25 y 64 años)',
           'Informe o transcripción de estudios solicitados
           (Prestación: Mamografía bilateral, craneocaudal y oblicua, 
            con proyección axilar  mujeres (en mayores de 49 años)',
            'Informe o transcripción de estudios solicitadoss(Prestación VDRL)',
            'Tratamiento instaurado (Prestación: Notificación de inicio de tratamiento)'
        ];
        $count_ids_validos = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
            '13' => 0,
            '14' => 0
        ];
        $count_ids_ausencia = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
            '13' => 0,
            '14' => 0
        ];
        $count_ids_errores = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0,
            '13' => 0,
            '14' => 0
        ];

        $progress = $this->output->createProgressBar($cantidad);
        $progress->setRedrawFrequency(100);

        foreach ($ids_prestaciones as $id) {
            $prestacion = Prestacion::findOrFail($id)->toArray();
            $resultado = $dr->verificar($prestacion);
            $progress->clear();

            $data = [
                'lote' => $lote->lote,
                'registro' => json_encode($prestacion)
            ];

            if ($resultado['success']) {
                if (array_key_exists('skip', $resultado)) {
                    $noRequiere++;
                } else {
                    $validas++;

                    foreach ($resultado['tiene'] as $id) {
                        $count_ids_validos[$id]++;
                    }

                    RechazoDR::create(
                        array_merge($data, [
                            'motivos' => json_encode([
                                'validados' => $this->mapearMotivos($resultado['tiene'])
                            ])
                        ])
                    );
                }
                // $this->line(json_encode($prestacion));
                // $this->info($resultado['message']);
            } else {
                if (array_key_exists('null', $resultado)) {
                    $sinDatosReportables++;
                    //$this->error(json_encode($resultado['ids']));
                    foreach ($resultado['ids'] as $id) {
                        $count_ids_ausencia[$id]++;
                    }
                    RechazoDR::create([
                        'lote' => $lote->lote,
                        'registro' => json_encode($prestacion),
                        'motivos' => json_encode([
                            'ausentes' => $this->mapearMotivos($resultado['ids'])
                        ])
                    ]);
                } elseif (array_key_exists('wrong', $resultado)) {
                    $invalidas++;
                    

                    $ids_ausentes = array_diff($resultado['requiere'], $resultado['tiene']);

                    foreach ($ids_ausentes as $id) {
                        $count_ids_ausencia[$id]++;
                    }

                    foreach ($resultado['tiene'] as $id) {
                        $count_ids_validos[$id]++;
                    }

                    $motivos = [
                        'ausentes' => $this->mapearMotivos(array_values($ids_ausentes))
                    ];

                    if (!empty($resultado['tiene'])) {
                        $motivos = array_merge($motivos, [
                            'validados' => $this->mapearMotivos($resultado['tiene'])
                        ]);
                    }

                    $data = array_merge($data, [
                        'motivos' => json_encode($motivos)
                    ]);

                    RechazoDR::create($data);
                } else {
                    $fueraDeRangos++;

                    foreach ($resultado['errores'] as $id) {
                        $count_ids_errores[$id]++;
                    }

                    foreach ($resultado['validados'] as $id) {
                        $count_ids_validos[$id]++;
                    }

                    $motivos = [
                        'errores' => $this->mapearMotivos($resultado['errores'])
                    ];

                    if (!empty($resultado['validados'])) {
                        $motivos = array_merge($motivos, [
                            'validados' => $this->mapearMotivos($resultado['validados'])
                        ]);
                    }

                    $data = array_merge($data, [
                        'motivos' => json_encode($motivos)
                    ]);

                    RechazoDR::create($data);
                }
                //$this->line(json_encode($prestacion));
                //$this->error($resultado['errors']);
            }
            $progress->setFormat("Progress: <info>%percent%</info>\033[32m%\033[0m <fg=white;bg=blue>%remaining%</>"
                ." Vacio: <error>{$sinDatosReportables}</error> Correctos:<info>{$validas}</info> Incorrecto: <error>"
                ."{$fueraDeRangos}</error> Ids invalidas: <error>{$invalidas}</error>");
            $progress->display();
            $progress->advance();
        }

        //DB::statement("INSERT into logs.revision (id_prestacion,validos,ausentes,errores) values ()");

        /*$resultados = [
            'lote' => $lote->lote,
            'sin' => $sinDatosReportables,
            'ids_incorrectos' => $invalidas,
            'rangos_incorrectos' => $fueraDeRangos,
            'rangos_correctos' => $validas,
            'started_at' => $start,
            'ended_at' => date("Y-m-d H:i:s"),
            'validados' => json_encode($count_ids_validos),
            'ausentes' => json_encode($count_ids_ausencia),
            'errores' => json_encode($count_ids_errores)
        ];*/

        //$this->info("Se validaron {$cantidad} prestaciones");
        //$this->info("No requiere datos reportables: {$noRequiere}");
        //$this->info(json_encode($resultados));

        //DB::table('logs.resultadosDR')->insert($resultados);
        $progress->finish();
    }

    public function mapearMotivos($array)
    {
        return array_map(function ($v) {
            return strval($v);
       	}, $array);
    }
}
