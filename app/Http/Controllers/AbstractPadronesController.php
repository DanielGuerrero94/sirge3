<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Database\QueryException;
use Validator;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

abstract class AbstractPadronesController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Devuelve el listado de areas
     * @param array_datos
     *
     * @return array vacío
     */
    protected function vaciarArray($linea)
    {
        foreach ($linea as $campo => $valor) {
            $linea[$campo] = '';
        }
        return $linea;
    }

    /**
     * Devuelve un bool indicando si el formato es válido para UTF-8 o no
     * @param array_datos
     *
     * @return boolean
     */
    protected function formatoValido($linea)
    {
        foreach ($linea as $campo => $valor) {
            if (! preg_match('//u', $valor)) {
                return false;
            }
        }
        return true;
    }
}
