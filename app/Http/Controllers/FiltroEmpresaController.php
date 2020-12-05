<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empresa;
use App\Galeria;
use App\Categoria;
use App\Ciudad;


class FiltroEmpresaController extends Controller
{
	public function ciudad(){
		return Ciudad::select('id','nombre')->get();
	}
	public function datos(Request $request){



		
		if (empty($request->ciudad_id) && empty($request->busqueda) && empty($request->subcategoria_id)) {


			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan','calificacion')->where('estado',1)->get();



		}
		elseif ($request->ciudad_id=='-1' && empty($request->busqueda) && empty($request->subcategoria_id)) {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->get();


		}

		elseif ($request->ciudad_id!='-1' && empty($request->busqueda) && empty($request->subcategoria_id) && !empty($request->ciudad_id)) {

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->where('ciudad_id',$request->ciudad_id)->get();


		}
		//Subcategoria

		elseif ($request->subcategoria_id=='-1' && empty($request->busqueda) && $request->ciudad_id=='-1') {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->get();


		}

		elseif ($request->subcategoria_id=='-1' && empty($request->busqueda) && $request->ciudad_id!='-1' && !empty($request->ciudad_id)) {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->where('ciudad_id',$request->ciudad_id)->get();


		}
		elseif (!empty( $request->subcategoria_id) && $request->subcategoria_id!='-1' && empty($request->busqueda) && !empty($request->ciudad_id)) {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->where('ciudad_id',$request->ciudad_id)->where('subcategoria_id',$request->subcategoria_id)->get();


		}


		//Campo buscar
		elseif (empty($request->subcategoria_id)  && !empty($request->busqueda) && empty($request->ciudad_id)) {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->where('nombre', 'like', '%' .$request->busqueda. '%')->get();


		}
		elseif ($request->subcategoria_id=="-1"  && !empty($request->busqueda) && $request->ciudad_id=="-1") {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->where('nombre', 'like', '%' .$request->busqueda. '%')->get();


		}

		elseif ($request->subcategoria_id=="-1"  && !empty($request->busqueda) && $request->ciudad_id!="-1" && !empty($request->ciudad_id) ) {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->where('nombre', 'like', '%' .$request->busqueda. '%')->where('ciudad_id',$request->ciudad_id)->get();


		}	
		elseif (empty($request->subcategoria_id)  && !empty($request->busqueda) && $request->ciudad_id!="-1" && !empty($request->ciudad_id) ) {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->where('nombre', 'like', '%' .$request->busqueda. '%')->where('ciudad_id',$request->ciudad_id)->get();


		}	

		elseif (!empty( $request->subcategoria_id) && $request->subcategoria_id!='-1' && !empty($request->busqueda) && !empty($request->ciudad_id)) {

			

			$empresa=Empresa::select('id',
				'nombre',
				'slug',
				'subcategoria_id',
				'logo',
				'telefono',
				'direccion',
				'email',
				'celular','plan')->where('estado',1)->where('ciudad_id',$request->ciudad_id)->where('subcategoria_id',$request->subcategoria_id)->where('nombre', 'like', '%' .$request->busqueda. '%')->get();


		}
		else{

			$empresa=[];

		}

		
    	$categoria=Categoria::get();//where
    	
    	return response()->json(['categoria'=> $categoria,'empresa'=>$empresa]);

    	

    }

    public function subCategoriaFiltro(Request $request){

    	
    	$ciudad=$request->ciudad_id;

    	$categorias = Categoria::whereHas('subcategorias.empresas', function ($query) use ($ciudad) {
    		$query->where('ciudad_id', '=', $ciudad);
    	})->with(['subcategorias.empresas' => function ($query)  use ($ciudad) {
    		$query->where('ciudad_id', '=', $ciudad);
    	}])->get();

    	return $categorias;

        /*

        $empresa=Empresa::select('subcategoria_id')->where('estado',1)->where('ciudad_id',$request->ciudad_id)->groupBy('subcategoria_id')->get();
    	$resultado=$empresa;
    	return $resultado;
    	*/

    }
}
