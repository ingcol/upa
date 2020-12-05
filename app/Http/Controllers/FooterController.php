<?php

namespace App\Http\Controllers;
use App\Nosotro;
use Illuminate\Http\Request;

class FooterController extends Controller
{

	public function index(){
		return Nosotro::select('nombre','mision','vision','valores','celular','whatsapp','correo','facebook','descripcion')->first();
	}

}
