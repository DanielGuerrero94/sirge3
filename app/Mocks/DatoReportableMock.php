<?php

namespace App\Mocks;

use App\Models\PSS\DatoReportable;

class DatoReportableMock extends DatoReportable
{
    /**
     * Definir la conexión de la bdd
     *
     * @var string
     */
    protected $connection = 'pgsql';
}
