<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use DB;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ModuloMenu;
use App\Models\Modulo;
use App\Models\Usuario;
use App\Models\Efector;

use App\Models\Dw\Ceb002;
use App\Models\Dw\Fc001;
use App\Models\Dw\AfRubro;

class HomeController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Vista principal en caso de no ingresar login o inicio
     * 
     * @return null
     */
    public function index(){
    	return redirect()->intended('inicio');
    }
    
    /**
     * Armado de menú
     * @param int $id_menu
     *
     * @return array
     */
    protected function getMenu($id_menu){
        $menu = array();
        $relaciones = ModuloMenu::join('sistema.modulos' , 'sistema.modulos_menu.id_modulo' , '=' , 'sistema.modulos.id_modulo')
            ->where('id_menu' , $id_menu)
            ->orderBy('nivel_1')
            ->orderBy('nivel_2')
            ->get();

        foreach ($relaciones as $key => $relacion){
            $modulo = Modulo::find($relacion->id_modulo);
            $menu[$modulo->id_modulo]['descripcion'] = $modulo->descripcion;
            $menu[$modulo->id_modulo]['modulo'] = $modulo->modulo;
            $menu[$modulo->id_modulo]['nivel_1'] = $modulo->nivel_1;
            $menu[$modulo->id_modulo]['nivel_2'] = $modulo->nivel_2;
            $menu[$modulo->id_modulo]['icono'] = $modulo->icono;
            $menu[$modulo->id_modulo]['arbol'] = $modulo->arbol;
            $menu[$modulo->id_modulo]['id_padre'] = $modulo->id_padre;
            $menu[$modulo->id_modulo]['hijos'] = [];
        }
        return $this->armaArbol($menu);
    }

    /**
     * Armo árbol con módulos
     * @param array $menu
     *
     * @return string
     */
    protected function armaArbol($menu){
        foreach ($menu as $key => $modulo){
            if ($modulo['id_padre']){
                $index = $modulo['id_padre'];
                array_push($menu[$index]['hijos'] , $modulo);
                unset ($menu[$key]);
            }
        }
        return $menu;
    }
    
    /**
     * Retorna vista principal
     *
     * @return null
     */
    public function inicio(){

        $data = [
            'usuario' => Auth::user()->nombre,
            'ocupacion' => Auth::user()->ocupacion,
            'mensaje' => Auth::user()->mensaje,
            'modulos' => $this->getMenu(Auth::user()->id_menu)
        ];
        return view('inicio' , $data);
    }

    /**
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
    protected function getDateInterval(){

        $dt = new \DateTime();
        $dt->modify('-1 month');
        $interval['max'] = $dt->format('Ym');
        $dt->modify('-6 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

    /**
     * Devuelve la info para generar un gráfico
     * 
     * @return json
     */
    protected function getProgresoCeb(){

        $interval = $this->getDateInterval();

        $periodos = Ceb002::select('periodo' , DB::raw('sum(beneficiarios) as b') , DB::raw('sum(beneficiarios_ceb) as c'))
                    ->whereBetween('periodo',[$interval['min'],$interval['max']])
                    ->groupBy('periodo')
                    ->orderBy('periodo')
                    ->get();

        foreach($periodos as $key => $periodo){
            $chart[0]['name'] = 'Benef. CEB';
            $chart[0]['data'][$key] = $periodo->c;

            $chart[1]['name'] = 'Benef. INS';
            $chart[1]['data'][$key] = $periodo->b;
        }
        return json_encode($chart);
    }

    /**
     * Devuelve la info para generar un gráfico
     * 
     * @return json
     */
    protected function getProgresoFc(){

        $interval = $this->getDateInterval();

        $periodos = Fc001::select('periodo' , DB::raw('sum(cantidad) as cf') , DB::raw('sum(monto) as mf'))
                        ->whereBetween('periodo' , [ $interval['min'] , $interval['max'] ])
                        ->groupBy('periodo')
                        ->orderBy('periodo')
                        ->get();
        foreach($periodos as $key => $periodo){
            $chart[0]['name'] = 'Prest. fact.';
            $chart[0]['data'][$key] = $periodo->cf;

            $chart[1]['name'] = 'Monto. fact.';
            $chart[1]['data'][$key] = (int)$periodo->mf;
        }
        return json_encode($chart);
    }

    /**
     * Devuelve la info para generar un gráfico
     *
     * @return json
     */
    protected function getFondosAll(){
        
        $fondos = AfRubro::join('estadisticas.af_001' , 'af_rubros.rubro' , '=' , 'estadisticas.af_001.rubro')
                        ->select('af_rubros.nombre as name' , DB::raw('sum(monto)::int as y'))
                        ->groupBy('af_rubros.nombre')
                        ->get();

        return json_encode($fondos);
    }

    /**
     * Devuelve listado de 6 meses 
     *
     * @return json
     */
    protected function getMesesArray(){

        $dt = new \DateTime();
        $dt->modify('-7 month');
        for ($i = 0 ; $i < 6 ; $i ++){
        $dt->modify('+1 month');

            $meses[$i] = strftime("%b" , $dt->getTimeStamp());
        }
        return json_encode($meses);
    }

    /**
     * Devuelve la cantidad total de prestaciones facturadas
     *
     * @return string
     */
    protected function getPrestacionesFacturadas(){
        $ps = Fc001::sum('cantidad');
        return round($ps/1000000 , 2) . 'M';
    }

    /**
     * Devuelve la cantidad de efectores activos
     *
     * @return int
     */
    protected function getEfectores(){
        return Efector::where('id_estado' , 1)->count();
    }

    /**
     * Devuelve el número de usuarios
     *
     * @return int
     */
    protected function getUsuarios(){
        return Usuario::where('activo' , 'S')->count();
    }

    /**
     * Retorna vista dashboard
     *
     * @return null
     */
    public function dashboard(){

        $data = [
            'page_title' => 'Dashboard',
            'grafico_ceb' => $this->getProgresoCeb(),
            'grafico_fc' => $this->getProgresoFc(),
            'grafico_af' => $this->getFondosAll(),
            'meses' => $this->getMesesArray(),
            'total_prestaciones' => $this->getPrestacionesFacturadas(),
            'total_efectores' => $this->getEfectores(),
            'total_usuarios' => $this->getUsuarios()

        ];
        return view ('dashboard' , $data);
    }
}
