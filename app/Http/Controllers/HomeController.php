<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    public function index(){
    	if (! Auth::check())
    		return view('login');
    	else
    		return view('dashboard');
    }
}
