<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nosotro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class NosotrosAdminController extends Controller
{
	public function __construct()
	{
		set_time_limit(8000000);
		$this->middleware('auth');
		

	}
	public function index(){
		if (Auth::user()->rol=='is_admin_rol') {
			return view('nosotros.index');
		}
		else{
			return view('errors.404');
		}
		}
		public function datos(){
			if (Auth::user()->rol=='is_admin_rol') {
				return Nosotro::select('nombre','mision','vision','valores','celular','whatsapp','correo','facebook','descripcion')->first();}

			}
			public function actualizar(Request $request){

				if (Auth::user()->rol=='is_admin_rol') {


					$nosotro=Nosotro::first();


					$nosotro->nombre=$request->nombre;
					$nosotro->descripcion=$request->descripcion;
					$nosotro->mision=$request->mision;
					$nosotro->vision=$request->vision;
					$nosotro->valores=$request->valores;
					$nosotro->whatsapp=$request->whatsapp;
					$nosotro->celular=$request->celular;
					$nosotro->correo=$request->correo;
					$nosotro->facebook=$request->facebook;


					if ($request->hasFile('url')) {

						$type=$request->url->getClientOriginalExtension();

						if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
							return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
						}
						else{

							$nameFile = $request->url;
							$newName = $nameFile->getClientOriginalExtension().'_'.time().rand().'.'.$nameFile->getClientOriginalExtension();

                      //amazon
							$path = $nameFile->storeAs('Nosotros', $newName,'s3');
							Storage::disk('s3')->setVisibility($path, 'public');

							$nosotro->url=Storage::disk('s3')->url($path);

						}



					}
					return $nosotro->update();
				}
			}
		}
