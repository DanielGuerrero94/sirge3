<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    /**
     * Muestra el formulario de registro
     *
     * @return view
     */
    public function index(){
    	return view('registration.main');
    }
}
