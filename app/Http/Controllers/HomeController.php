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
use App\Models\Dw\Ceb002;

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
     * Retorna vista dashboard
     *
     * @return null
     */
    public function dashboard(){

        $periodos = Ceb002::select('periodo' , DB::raw('sum(beneficiarios) as b') , DB::raw('sum(beneficiarios_ceb) as c'))
                    ->groupBy('periodo')
                    ->orderBy('periodo')
                    ->get();

        foreach($periodos as $key => $periodo){
            /*
            $chart['bene_ceb']['name'] = 'Benef. CEB.';
            $chart['bene_ceb']['data'][$key] = $periodo->c;

            $chart['bene_ins']['name'] = 'Benef. INS.';
            $chart['bene_ins']['data'][$key] = $periodo->b;
            */

            $dt = \DateTime::createFromFormat('Ym' , $periodo->periodo);

            $meses[] = strftime("%b" , $dt->getTimeStamp());

            $chart[0]['name'] = 'Benef. CEB';
            $chart[0]['data'][$key] = $periodo->c;

            $chart[1]['name'] = 'Benef. INS';
            $chart[1]['data'][$key] = $periodo->b;

        }

        $data = [
            'page_title' => 'Dashboard',
            'series' => json_encode($chart),
            'meses' => json_encode($meses)
        ];
        return view ('dashboard' , $data);
    }
}
