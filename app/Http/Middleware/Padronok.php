<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Lote;
use App\Models\Subida;
use App\Models\ExcepcionDDJJ;

class Padronok
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {        
        
        if(intval(date('d')) <= ExcepcionDDJJ::first()->dia){
            $dt = new \DateTime();
            $dt->modify('-1 month');
            $dt->modify('first day of this month');
            $primer_dia = $dt->format('Y-m-d');            
        }
        else{
            $primer_dia = date('Y-m-01');   
        }
        $query = Lote::join('sistema.subidas','sistema.subidas.id_subida','=','sistema.lotes.id_subida')    
            ->where('sistema.lotes.id_estado',3)
            ->where('sistema.lotes.id_provincia',$this->auth->user()->id_provincia)
            ->whereBetween('sistema.lotes.created_at',array($primer_dia, date('Y-m-d')))
            ->whereIn('sistema.subidas.id_padron',[1,2,3]);

            //return var_dump($query->toSql());      
            //array(2) { [0]=> string(10) "2016-06-01" [1]=> string(10) "2016-06-13" }            

        if ($query->count() >= 3){            
            return $next($request);
        } else {
            return redirect('ddjj-doiu-9')->with('status' , 'No presentó todos los padrones en el mes.');
        }
    }
}
