<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
    	if (Auth::check()){
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->intended('/login');            
        }
    }
    
    public function dashboard(){
        $data = [
            'page_title' => 'Dashboard'
        ];
        
        return view('dashboard' , $data);
    }
}
