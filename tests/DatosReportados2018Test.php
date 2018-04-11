<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatosReportados2018Test extends TestCase
{
    protected $pssEmbarazo = ['CTC005W78','CTC006W78','CTC007O24.4','CTC022O24.4','CTC007O10','CTC007O10.4','CTC022O10',
    'CTC022O10.4','CTC007O16','CTC022O16','CTC017P05','CTC010W78'];

    public function id1provider()
    {
        return [
            [
                'codigo_prestacion' => 'CTC001A97',
                'fecha_nacimiento' => '2017-10-01',
                'fecha_prestacion' => '2017-12-01',
                'dr' => '1,55',
            ],
            [
                'codigo_prestacion' => 'CTC001T83',
                'fecha_nacimiento' => '2000-12-01',
                'fecha_prestacion' => '2017-12-01',
                'dr' => '20,5',
            ],
            [
                'codigo_prestacion' => 'CTC005W78',
                'fecha_nacimiento' => '2010-12-01',
                'fecha_prestacion' => '2017-12-01',
                'dr' => '120,300',
            ],
            [
                'codigo_prestacion' => 'CTC001T79',
                'fecha_nacimiento' => '2010-12-01',
                'fecha_prestacion' => '2017-12-01',
                'dr' => '55',
            ],
        ];
    }

    /**
     * Rangos de peso
     *
     * @test
     * @dataProvider id1provider
     */
    public function datoReportable1($codigo_prestacion, $fecha_nacimiento, $fecha_prestacion, $dr)
    {
        $regex = '/\d{1,3}(?:[,\.]\d{1,3})?/';

        //Verfico que cumpla mascara
        $this->assertTrue(boolval(preg_match($regex, $dr)));

        //Transformo el valor de dr para comparar
        $dr = preg_replace('/(\d+),(\d+)/', '$1.$2', $dr);
        $dr = floatval($dr);

        //Verifico si el codigo de prestacion es de embarazada
        if (in_array($codigo_prestacion, $this->pssEmbarazo)) {
            $this->assertTrue($dr >= 40 && $dr <= 250);
        } else {
            //Calculo la edad
            $edad = date_diff(date_create($fecha_prestacion), date_create($fecha_nacimiento));
            $edad = $edad->format('%y');
            if ($edad < 10) {
                $this->assertTrue($dr >= 1.5 && $dr <= 70);
            } else {
                $this->assertTrue($dr >= 15 && $dr <= 250);
            }
        }
    }

    /**
     * Pruebo en postgres
     *
     * @test
     * @dataProvider id1provider
     */
    public function datoReportable1DB($codigo_prestacion, $fecha_nacimiento, $fecha_prestacion, $dr)
    {
        $this->assertTrue(DB::select("select valido_dr_1('{$dr}', '{$codigo_prestacion}', '{$fecha_nacimiento}'
        	, '{$fecha_prestacion}')")[0]->valido_dr_1);
    }

    public function id2provider()
    {
        return [
            [
                'codigo_prestacion' => 'CTC001A97',
                'fecha_nacimiento' => '2017-10-01',
                'fecha_prestacion' => '2017-12-01',
                'dr' => '45',
            ],
            [
                'codigo_prestacion' => 'CTC001T83',
                'fecha_nacimiento' => '2000-12-01',
                'fecha_prestacion' => '2017-12-01',
                'dr' => '190',
            ],
            [
                'codigo_prestacion' => 'CTC005W78',
                'fecha_nacimiento' => '2010-12-01',
                'fecha_prestacion' => '2017-12-01',
                'dr' => '145',
            ],
            [
                'codigo_prestacion' => 'CTC001T79',
                'fecha_nacimiento' => '2010-12-01',
                'fecha_prestacion' => '2017-12-01',
                'dr' => '110',
            ],
        ];
    }

    /**
     * Rangos de peso
     *
     * @test
     * @dataProvider id2provider
     */
    public function datoReportable2($codigo_prestacion, $fecha_nacimiento, $fecha_prestacion, $dr)
    {
        //Verifico si el codigo de prestacion es de embarazada
        if (in_array($codigo_prestacion, $this->pssEmbarazo)) {
            $this->assertTrue($dr >= 140 && $dr <= 200);
        } else {
            //Calculo la edad
            $edad = date_diff(date_create($fecha_prestacion), date_create($fecha_nacimiento));
            $edad = $edad->format('%y');
            if ($edad < 10) {
                $this->assertTrue($dr >= 40 && $dr <= 180);
            } else {
                $this->assertTrue($dr >= 110 && $dr <= 220);
            }
        }
    }

    /**
     * Pruebo en postgres
     *
     * @test
     * @dataProvider id2provider
     */
    public function datoReportable2DB($codigo_prestacion, $fecha_nacimiento, $fecha_prestacion, $dr)
    {
        $this->assertTrue(DB::select("select valido_dr_2('{$dr}', '{$codigo_prestacion}', '{$fecha_nacimiento}'
        	, '{$fecha_prestacion}')")[0]->valido_dr_2);
    }

    public function id3provider()
    {
        return [
            ['120/40'],
            ['160/110'],
            ['120/085'],
        ];
    }

    /**
     * A basic test example.
     *
     * @test
     * @dataProvider id3provider
     */
    public function datoReportable3($dr)
    {
        $regex = '/\d{2,3}\/\d{2,3}/';
        $this->assertTrue(boolval(preg_match($regex, $dr)));
        [$sintolica, $diastolica] = explode('/', $dr);
        $min = 50;
        $max = 220;
        $this->assertTrue($sintolica >= $min && $sintolica <= $max);
        $minimo = 40;
        $maximo = 150;
        $this->assertTrue($diastolica >= $minimo && $diastolica <= $maximo);
    }

    /**
     * Valida desde una funcion en postgres
     *
     * @test
     * @dataProvider id3provider
     */
    public function datoReportable3ConDB($dr)
    {
        $this->assertTrue(DB::select("select prestaciones.valido_dr_3('{$dr}')")[0]->valido_dr_3);
    }

    /**
     * Valida desde una funcion en postgres
     *
     * @test
     * @dataProvider id3provider
     */
    public function datoReportable3ConDBJson($dr)
    {
        $this->assertTrue(DB::select("select prestaciones.valido_dr_3_json('{$dr}')")[0]->valido_dr_3_json);
    }

    /**
     * Valida desde una funcion en postgres
     *
     * @test
     * @dataProvider id3provider
     */
    public function datoReportable3ConDBfullregex($dr)
    {
        $this->assertTrue(DB::select("select prestaciones.valido_dr_3_full_regex('{$dr}')")[0]->valido_dr_3_full_regex);
    }

    public function id4provider()
    {
        return [
            ['35,5'],
            ['29,1'],
            ['53,9'],
        ];
    }

    /**
     * A basic test example.
     *
     * @test
     * @dataProvider id4provider
     */
    public function datoReportable4($dr)
    {
        $regex = '/\d{1,2}(?:[,\.]\d)?/';

        //Verifico la mascara
        $this->assertTrue(boolval(preg_match($regex, $dr)));

        //Transformo el valor de dr para comparar
        $dr = preg_replace('/(\d+),(\d+)/', '$1.$2', $dr);
        $dr = floatval($dr);

        $this->assertTrue($dr >= 29 && $dr <= 54);
    }

    /**
     * Valida desde una funcion en postgres
     *
     * @test
     * @dataProvider id4provider
     */
    public function datoReportable4ConDB($dr)
    {
        $this->assertTrue(DB::select("select valido_dr_4('{$dr}')")[0]->valido_dr_4);
    }

    public function id5provider()
    {
        return [
            ['32,3'],
            ['4,0'],
            ['43,6'],
        ];
    }

    /**
     * A basic test example.
     *
     * @test
     * @dataProvider id5provider
     */
    public function datoReportable5($dr)
    {
        $regex = '/(\d{1,2}),[0-6]/';
        $values = [];
        $this->assertTrue(boolval(preg_match($regex, $dr, $values)));
        array_shift($values);
        [$semanas] = $values;
        $min = 4;
        $max = 43;
        $this->assertTrue($semanas >= $min && $semanas <= $max);
    }

    /**
     * Valida desde una funcion en postgres
     *
     * @test
     * @dataProvider id5provider
     */
    public function datoReportable5ConDB($dr)
    {
        $this->assertTrue(DB::select("select valido_dr_5('{$dr}')")[0]->valido_dr_5);
    }

    public function id6provider()
    {
        return [
            ['c:00/e:01/o:12'],
            ['C:20/P:10/O:14'],
            ['c:2/p:30/O:15'],
            ['c:30/E:14/o:2'],
        ];
    }

    /**
     * Valida caries/perdidos/obturados
     * y caries/extraccion indicada/obturados
     *
     * @test
     * @dataProvider id6provider
     */
    public function datoReportable6($dr)
    {
        //Valida mascara C/P/O, c/e/o con rangos de valores entre 0 y 32
        $regex = '/^[Cc]:(?:[0-2]?[0-9]|3[0-2])\/[eEpP]:(?:[0-2]?[0-9]|3[0-2])\/[oO]:(?:[0-2]?[0-9]|3[0-2])$/';
        $this->assertTrue(boolval(preg_match($regex, $dr)));
    }

    /**
     * Valida desde una funcion en postgres
     *
     * @test
     * @dataProvider id6provider
     */
    public function datoReportable6ConDB($dr)
    {
        $this->assertTrue(DB::select("select prestaciones.valido_dr_6('{$dr}')")[0]->valido_dr_6);
    }

    public function id7provider()
    {
        return [
            ['ODpasa'],
            ['ODnopasa'],
            ['OIpasa'],
            ['OInopasa'],
        ];
    }

    /**
     * A basic test example.
     *
     * @test
     * @dataProvider id7provider
     */
    public function datoReportable7($dr)
    {
        //Valida mascara
        $regex = '/O[DI](?:no)?pasa/';
        $this->assertTrue(boolval(preg_match($regex, $dr)));
    }
}
