<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;

class WebController extends Controller
{
	public function index(){
		return view('web.index');
	}
	public function detalleEmpresa($id){


		$validarId=Empresa::where('id',$id)->where('estado',1)->first();

		if ($validarId && $validarId->plan!='gratis') {
			return view('web.detalle_empresa',compact('id'));
		}
		else{

			return view('errors.404');

		}	

	}
	public function verDetalleempresa($id){
		return Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','descripcion','servicios','plan','calificacion')->where('id',$id)->where('estado',1)->with('galeria')->with('menus')->first();
	}
}
