<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Promocion;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use  DatePeriod;
class PromocionWebController extends Controller
{
	public function index(){
		return view('web.promocion.index');
	}

	public function getFechaActual(){
		$FechaActual= Carbon::now();
		return $FechaActual->format('Y-m-d');
		//date('w'); día actual
	}

	public function datos(){
		
		$promocion=Empresa::has('promociones')->with('promociones')->get();

		return $promocion;



	}
}
