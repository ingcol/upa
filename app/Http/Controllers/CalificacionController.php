<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calificacion;
use App\Empresa;
use App\Http\Requests\CalificacionRequest;



class CalificacionController extends Controller
{
	public function api(CalificacionRequest $request){


		$idTelefonoUsuario=Calificacion::where('empresa_id',$request->empresa_id)->where('idTelefono',$request->idTelefono)->first();
		if ($idTelefonoUsuario) {
    		# Actualización

			$actualizarCalificacion=Calificacion::where('idTelefono',$request->idTelefono)->update(['calificacion' =>$request->calificacion]);

    		#Consulta promedio empresa

			$cantEmpresa=Calificacion::where('empresa_id',$request->empresa_id)->count();
			$sumaTotalCalificacion=Calificacion::where('empresa_id',$request->empresa_id)->sum('calificacion');
			$nuevoPromedioEmpresa=$sumaTotalCalificacion/$cantEmpresa;
    		#Actualizazión
			$actualizarCalificacionEmpresa=Empresa::where('id',$request->empresa_id)->update(['calificacion' =>$nuevoPromedioEmpresa]);
		}
		else{
    		#Nuevo
    		#Validar

			$calificacion=new Calificacion;
			$calificacion->empresa_id=$request->empresa_id;
			$calificacion->idTelefono=$request->idTelefono;
			$calificacion->calificacion=$request->calificacion;
			$calificacion->save();

    		#Consulta promedio empresa

			$cantEmpresa=Calificacion::where('empresa_id',$request->empresa_id)->count();
			$sumaTotalCalificacion=Calificacion::where('empresa_id',$request->empresa_id)->sum('calificacion');
			$nuevoPromedioEmpresa=$sumaTotalCalificacion/$cantEmpresa;
    		#Actualizazión
			$actualizarCalificacionEmpresa=Empresa::where('id',$request->empresa_id)->update(['calificacion' =>$nuevoPromedioEmpresa]);

			return $actualizarCalificacionEmpresa;




		}



	}
}
