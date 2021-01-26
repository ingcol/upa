<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Publicidad;
use App\Ciudad;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PublicidadRequestStore;
use App\Http\Requests\PublicidadRequestUpdate;
use App\Helpers\Helper;


class PublicidadController extends Controller
{
	public function __construct()
	{
		set_time_limit(8000000);
		$this->middleware('auth');
		

	}
	public function index(){

		if (Auth::user()->rol=='is_admin_rol') {
			return view('publicidad.index');
		}
		else{
			return view('errors.404');
		}


	}

	public function datos(Request $request){


		if (Auth::user()->rol=='is_admin_rol') {

			if (empty($request->filtrarCategoria) && empty($request->filtrarCiudad)) {
				# code...
			return Publicidad::orderBy('publicidades.id','DESC')->select('publicidades.nombre','categoria','url','publicidades.descripcion','intermedia','ciudad_id','estado','orden','ciudades.nombre as nombreCiudad','publicidades.id')->leftjoin('ciudades', 'ciudades.id', '=', 'publicidades.ciudad_id')->get();
		}
		elseif (!empty($request->filtrarCategoria) && empty($request->filtrarCiudad)) {



			return Publicidad::orderBy('publicidades.id','DESC')->select('publicidades.nombre','categoria','url','publicidades.descripcion','intermedia','ciudad_id','estado','orden','ciudades.nombre as nombreCiudad','publicidades.id')->leftjoin('ciudades', 'ciudades.id', '=', 'publicidades.ciudad_id')->where('publicidades.categoria',$request->filtrarCategoria)->get();
			
		}

		elseif (empty($request->filtrarCategoria) && !empty($request->filtrarCiudad)) {



			return Publicidad::orderBy('publicidades.id','DESC')->select('publicidades.nombre','categoria','url','publicidades.descripcion','intermedia','ciudad_id','estado','orden','ciudades.nombre as nombreCiudad','publicidades.id')->leftjoin('ciudades', 'ciudades.id', '=', 'publicidades.ciudad_id')->where('publicidades.ciudad_id',$request->filtrarCiudad)->get();
			
		}
		else{
			return Publicidad::orderBy('publicidades.id','DESC')->select('publicidades.nombre','categoria','url','publicidades.descripcion','intermedia','ciudad_id','estado','orden','ciudades.nombre as nombreCiudad','publicidades.id')->leftjoin('ciudades', 'ciudades.id', '=', 'publicidades.ciudad_id')->where('publicidades.ciudad_id',$request->filtrarCiudad)->where('publicidades.categoria',$request->filtrarCategoria)->get();

		}


		}
	}

	public function guardarPublicidad(PublicidadRequestStore $request)
	{

		if (Auth::user()->rol=='is_admin_rol') {
			$publicidad=new Publicidad;
			$publicidad->nombre=$request->nombre;
			$publicidad->ciudad_id=$request->ciudad_id;
			$publicidad->url=$request->url;
			$publicidad->categoria=$request->categoria;
			$publicidad->estado=$request->estado;
			$publicidad->orden=$request->orden;
			$publicidad->descripcion=$request->descripcion;
			if ($request->hasFile('intermedia')) {

				$type=$request->intermedia->getClientOriginalExtension();

				if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
					return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
				}
				else{

					$redimensionImagen = Helper::uploadFilePublicidad( "intermedia", 'publicidad/');

					$publicidad->intermedia=$redimensionImagen;

				}



			}
			$publicidad->save();
			return $publicidad;

		}


	}
	public function ActualizarPublicidad(PublicidadRequestUpdate $request,$id){
		
		if (Auth::user()->rol=='is_admin_rol') {
			$publicidad=Publicidad::find($id);
			$publicidad->nombre=$request->nombre;
			$publicidad->ciudad_id=$request->ciudad_id;
			$publicidad->url=$request->url;
			$publicidad->categoria=$request->categoria;
			$publicidad->estado=$request->estado;
			$publicidad->orden=$request->orden;
			$publicidad->descripcion=$request->descripcion;
			if ($request->hasFile('intermedia')) {

				$type=$request->intermedia->getClientOriginalExtension();

				if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
					return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
				}
				else{

					Storage::disk('s3')->delete('publicidad/'.$publicidad->intermedia);

					$redimensionImagen = Helper::uploadFilePublicidad( "intermedia", 'publicidad/');

					$publicidad->intermedia=$redimensionImagen;

				}



			}
			$publicidad->update();
			return $publicidad;

		}

	}



	public function ciudad(){
		return Ciudad::select('id','nombre')->get();
	}
	public function eliminarPublicidad($id){

		
		Publicidad::where('id',$id)->delete();


	}
}
