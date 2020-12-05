<?php

namespace App\Http\Controllers;

use App\Profesional;
use App\Profesion;
use Illuminate\Http\Request;

class ProfesionController extends Controller
{

    public function __construct()
    {
      //  $this->middleware('auth');
    }

 

    public function api($ciudad)
    {
  
        $profesiones = Profesion::whereHas('subprofesionesP.profesionales', function ($query) use ($ciudad) {
            $query->where('ciudad_id', '=', $ciudad);
        })->with(['subprofesionesP.profesionales' => function ($query)  use ($ciudad) {
            $query->where('ciudad_id', '=', $ciudad);
        }])->get();



     /*   $names = $categorias->reject(function ($categoria) use ($ciudad) {
            return  $categoria->reject(function ($subcategoria) use ($ciudad){
                return  $nam = $subcategoria->reject(function ($empresa) use ($ciudad) {
                    return $empresa->ciudad_id !== $ciudad;
                })
                ->map(function ($empresa) {
                    return $empresa;
                });
            })
            ->map(function ($subcategoria) {
                return $subcategoria;
            });
        })
        ->map(function ($categoria) {
            return $categoria;
        });
*/
       // dd($categorias);
        

 /*       $categorias1 = Categoria::wherehas('subcategorias.empresas', function ($query) {
            $query->where('ciudad_id', '=', '1');
        })->get();
*/
            return [
                'data' => $profesiones->toArray()
            ];
 
    }

  
}
