<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Promocion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PromocionRequestStore;
use App\Http\Requests\PromocionRequestUpdate;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use  DatePeriod;

class PromocionController extends Controller
{
	private  $empresa_id;
	
	public function __construct()
	{
		set_time_limit(8000000);
		$this->middleware('auth');
		

	}

	

	public function index(){

		return view('promocion.index');


	}
	public function getEmpresaId(){
		$empresa=Empresa::where('user_id',Auth::user()->id)->first();
		return $empresa->id;
	}
	public function getFechaActual(){
		$FechaActual= Carbon::now();
		return $FechaActual->format('Y-m-d');
		//date('w'); día actual
	}

	public function  mostrarPublicidad(){
		$diaActual=date('w');
		
		if ($diaActual==0) {
			$where='domingo';

		}
		elseif ($diaActual==1) {
			$where='lunes';
		}
		elseif ($diaActual==2) {
			$where='martes';
		}
		elseif ($diaActual==3) {
			$where='miercoles';
		}
		elseif ($diaActual==4) {
			$where='jueves';
		}
		elseif ($diaActual==5) {
			$where='viernes';
		}
		else{
			$where='sabado';
		}

		//fechafin<=fechaActal

		dd(Promocion::where($where,$diaActual)->where('estado',1)->where('fechainicio','<=',$this->getFechaActual())->where('fechafin','>=',$this->getFechaActual())->get());
	}
	public function datos(){

		

		if(Auth::user()->rol=='is_admin_rol'){
			$promocion=Promocion::orderBy('id','DESC')->select('id','titulo','fechainicio','fechafin','descripcion','valor','file_url','tipo','estado','domingo','lunes','martes','miercoles','jueves','viernes','sabado','empresa_id')->get();
		}
		else{
			$promocion=Promocion::orderBy('id','DESC')->select('id','titulo','fechainicio','fechafin','descripcion','valor','file_url','tipo','estado','domingo','lunes','martes','miercoles','jueves','viernes','sabado','empresa_id')->where('empresa_id',$this->getEmpresaId())->get();
		}
		
		
		$rolUsuario=Auth::user()->rol;
		return response()->json(['promocion' =>$promocion,'rolUsuario' =>$rolUsuario,'FechaActual'=>$this->getFechaActual()] );


	}
	
	public function guardarPromocion(PromocionRequestStore $request){


		if ($request->fechainicio<$this->getFechaActual()) {
			return response()->json(['errors' => ['message' => ['La fecha de inicio no debe ser menor a la fecha actual']]], 422);
		}
		if ($request->fechainicio > $request->fechafin) {
			return response()->json(['errors' => ['message' => ['La fecha de inicio no debe ser mayor a la fecha de finalización']]], 422);
		}


		

		$promocion=new Promocion;

		if ($request->hasFile('file')) {

			$type=$request->file->getClientOriginalExtension();

			if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
				return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
			}
			else{

				$nameFile = $request->file;
				$newName = $nameFile->getClientOriginalExtension().'_'.time().rand().'.'.$nameFile->getClientOriginalExtension();

                      //amazon
				$path = $nameFile->storeAs('Promociones', $newName,'s3');
				Storage::disk('s3')->setVisibility($path, 'public');

				//save
				$promocion->file=$request->file->getClientOriginalName();
				$promocion->file_name=$newName;
				$promocion->file_type=$nameFile->getClientOriginalExtension();
				$promocion->file_url=Storage::disk('s3')->url($path);

			}

		}
		
		$promocion->titulo=$request->titulo;
		$promocion->descripcion=$request->descripcion;
		$promocion->fechainicio=$request->fechainicio;
		$promocion->fechafin=$request->fechafin;
		$promocion->estado=false;

		$promocion->tipo=$request->tipo;
		if (Auth::user()->rol!='is_admin_rol') {
			$promocion->estado=false;
			$promocion->empresa_id=$this->getEmpresaId();
		}
		else{
			if (empty($request->empresa_id) or !is_numeric($request->empresa_id)) {
				return response()->json(['errors' => ['message' => ['Seleccione una empresa']]], 422);
			}
			else{
				$promocion->empresa_id=$request->empresa_id;
			}
			$promocion->estado=$request->estado;





		}

		if ($request->domingo!='true' && $request->lunes!='true' && $request->martes!='true' && $request->miercoles!='true' && $request->jueves	!='true' && $request->viernes!='true' && $request->sabado!='true') {

			return response()->json(['errors' => ['message' => ['Selecione días de la semana para mostrar']]], 422);
		}

		if ($request->domingo=='true') {
			$promocion->domingo=0;
		}
		if ($request->lunes=='true') {
			$promocion->lunes=1;



		}

		if ($request->martes=='true') {
			$promocion->martes=2;
		}
		if ($request->miercoles =='true') {
			$promocion->miercoles=3;
		}
		if ($request->jueves=='true') {
			$promocion->jueves=4;
		}
		if ($request->viernes=='true') {
			$promocion->viernes=5;
		}
		if ($request->sabado=='true') {
			$promocion->sabado=6;
		}

				//Evaluar días de la semana entre el rango
		$start = new DateTime($request->fechainicio);
		$end = new DateTime($request->fechafin);

		$interval = new DateInterval("P1D");
		$daterange = new DatePeriod($start, $interval ,$end);


		$domingo=0;
		$lunes=0;
		$martes=0;
		$miercoles=0;
		$jueves=0;
		$viernes=0;
		$sabado=0;


		foreach($daterange as $date){
			$days = $date->format("w");

			if ($request->domingo=='true' && $days==0) {
				$domingo++;
			}
			if ($request->lunes=='true' && $days==1) {
				$lunes++;
			}
			if ($request->martes=='true' && $days==2) {
				$martes++;
			}
			if ($request->miercoles=='true' && $days==3) {
				$miercoles++;
			}
			if ($request->jueves=='true' && $days==4) {
				$jueves++;
			}
			if ($request->viernes=='true' && $days==5) {
				$viernes++;
			}
			if ($request->sabado=='true' && $days==6) {
				$sabado++;
			}

		}

		if ($request->domingo=='true' && !$domingo) {
			return response()->json(['errors' => ['message' => ['El día domingo no existe en este rango de fechas']]], 422);
		}
		if ($request->lunes=='true' && !$lunes) {
			return response()->json(['errors' => ['message' => ['El día lunes no existe en este rango de fechas']]], 422);
		}
		if ($request->martes=='true' && !$martes) {
			return response()->json(['errors' => ['message' => ['El día martes no existe en este rango de fechas']]], 422);
		}
		if ($request->miercoles=='true' && !$miercoles) {
			return response()->json(['errors' => ['message' => ['El día miércoles no existe en este rango de fechas']]], 422);
		}
		if ($request->jueves=='true' && !$jueves) {
			return response()->json(['errors' => ['message' => ['El día jueves no existe en este rango de fechas']]], 422);
		}
		if ($request->viernes=='true' && !$viernes) {
			return response()->json(['errors' => ['message' => ['El día viernes no existe en este rango de fechas']]], 422);
		}
		if ($request->sabado=='true' && !$sabado) {
			return response()->json(['errors' => ['message' => ['El día sábado no existe en este rango de fechas']]], 422);
		}
		$promocion->save();

		return $promocion;

		

	}
	public function actualizarPromocion(PromocionRequestUpdate $request,$id){


		if ($request->fechainicio > $request->fechafin) {
			return response()->json(['errors' => ['message' => ['La fecha de inicio no debe ser mayor a la fecha de finalización']]], 422);
		}



		$promocion=Promocion::find($id);

		if ($request->hasFile('file')) {

			$type=$request->file->getClientOriginalExtension();

			if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
				return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
			}
			else{

				$nameFile = $request->file;
				$newName = $nameFile->getClientOriginalExtension().'_'.time().rand().'.'.$nameFile->getClientOriginalExtension();

                      //amazon
				$path = $nameFile->storeAs('Promociones', $newName,'s3');
				Storage::disk('s3')->setVisibility($path, 'public');

				//save
				$promocion->file=$request->file->getClientOriginalName();
				$promocion->file_name=$newName;
				$promocion->file_type=$nameFile->getClientOriginalExtension();
				$promocion->file_url=Storage::disk('s3')->url($path);
				
				

			}

		}
		
		$promocion->titulo=$request->titulo;
		if ($request->descripcion!='null') {
			$promocion->descripcion=$request->descripcion;
		}

		if (!$promocion->estado) {


			$promocion->fechainicio=$request->fechainicio;
			$promocion->fechafin=$request->fechafin;

		}
		if (Auth::user()->rol=='is_admin_rol'){
			$promocion->estado=$request->estado;
			if (empty($request->empresa_id) or !is_numeric($request->empresa_id)) {
				return response()->json(['errors' => ['message' => ['Seleccione una empresa']]], 422);
			}
			else{
				$promocion->empresa_id=$request->empresa_id;
			}
		}





		
		$promocion->tipo=$request->tipo;
		if ($request->domingo!='true' && $request->lunes!='true' && $request->martes!='true' && $request->miercoles!='true' && $request->jueves	!='true' && $request->viernes!='true' && $request->sabado!='true') {

			return response()->json(['errors' => ['message' => ['Selecione días de la semana para mostrar']]], 422);
		}

		if ($request->domingo=='true') {
			$promocion->domingo=0;
		}
		if ($request->lunes=='true') {
			$promocion->lunes=1;



		}

		if ($request->martes=='true') {
			$promocion->martes=2;
		}
		if ($request->miercoles =='true') {
			$promocion->miercoles=3;
		}
		if ($request->jueves=='true') {
			$promocion->jueves=4;
		}
		if ($request->viernes=='true') {
			$promocion->viernes=5;
		}
		if ($request->sabado=='true') {
			$promocion->sabado=6;
		}

				//Evaluar días de la semana entre el rango
		$start = new DateTime($request->fechainicio);
		$end = new DateTime($request->fechafin);

		$interval = new DateInterval("P1D");
		$daterange = new DatePeriod($start, $interval ,$end);


		$domingo=0;
		$lunes=0;
		$martes=0;
		$miercoles=0;
		$jueves=0;
		$viernes=0;
		$sabado=0;


		foreach($daterange as $date){
			$days = $date->format("w");

			if ($request->domingo=='true' && $days==0) {
				$domingo++;
			}
			if ($request->lunes=='true' && $days==1) {
				$lunes++;
			}
			if ($request->martes=='true' && $days==2) {
				$martes++;
			}
			if ($request->miercoles=='true' && $days==3) {
				$miercoles++;
			}
			if ($request->jueves=='true' && $days==4) {
				$jueves++;
			}
			if ($request->viernes=='true' && $days==5) {
				$viernes++;
			}
			if ($request->sabado=='true' && $days==6) {
				$sabado++;
			}

		}

		if ($request->domingo=='true' && !$domingo) {
			return response()->json(['errors' => ['message' => ['El día domingo no existe en este rango de fechas']]], 422);
		}
		if ($request->lunes=='true' && !$lunes) {
			return response()->json(['errors' => ['message' => ['El día lunes no existe en este rango de fechas']]], 422);
		}
		if ($request->martes=='true' && !$martes) {
			return response()->json(['errors' => ['message' => ['El día martes no existe en este rango de fechas']]], 422);
		}
		if ($request->miercoles=='true' && !$miercoles) {
			return response()->json(['errors' => ['message' => ['El día miércoles no existe en este rango de fechas']]], 422);
		}
		if ($request->jueves=='true' && !$jueves) {
			return response()->json(['errors' => ['message' => ['El día jueves no existe en este rango de fechas']]], 422);
		}
		if ($request->viernes=='true' && !$viernes) {
			return response()->json(['errors' => ['message' => ['El día viernes no existe en este rango de fechas']]], 422);
		}
		if ($request->sabado=='true' && !$sabado) {
			return response()->json(['errors' => ['message' => ['El día sábado no existe en este rango de fechas']]], 422);
		}

		$promocion->update();

		return $promocion;

		

	}
}
