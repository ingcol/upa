<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nosotro;
class NosotrosController extends Controller
{
    public function index(){

    	return view('web.nosotros.index');
    }
    public function datos(){

    	return Nosotro::select('descripcion','url','nombre','mision','valores','vision'
    )->first(
    );

    }
}
