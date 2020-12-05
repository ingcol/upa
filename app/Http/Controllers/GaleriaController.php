<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Galeria;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class GaleriaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = Empresa::withCount(['galeria'])->findOrFail($request->input('empresa_id'));
        
        if($empresa->galeria_count > 2 ){
            $notification = array(
                'message' => 'Solo puede agregar 3 imágenes',
                'alert-type' => 'warning'
            );
        } else {


            if($request->hasFile('url')) {

             $foto = Helper::uploadFilefoto( "url", 'empresas/');
             $request->merge(['url' => $foto]);
         }

         $fotoo = Galeria::create($request->input()); 


         $notification = array(
            'message' => 'Registro creado correctamente',
            'alert-type' => 'info'
        );
     }
     return redirect()->back()->with($notification);

 }

 public function upload(Request $request)
 {

    $empresa = Empresa::withCount(['galeria'])->findOrFail($request->input('empresa_id'));

    if($empresa->galeria_count > 2 ){
        abort(403, 'Solo puede agregar 3 imágenes');
    } else {


        if($request->hasFile('url')) {

         $foto = Helper::uploadFilefoto( "url", 'empresas/');
         $request->merge(['url' => $foto]);
     }

     $fotoo = Galeria::create($request->input()); 


     $notification = array(
        'message' => 'Registro creado correctamente',
        'alert-type' => 'info'
    );
 }
 return redirect()->back()->with($notification);
 
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $fotoo = Galeria::findOrfail($request->id);

        if($request->hasFile('url')) 
        {
           if(!empty($fotoo->foto))
           {
               \Storage::disk('s3')->delete('empresas/'.$fotoo->foto);
           }

           $foto = Helper::uploadFilefoto( "url", 'empresas/');

           $request->merge(['url' => $foto]);
       }

       $fotoo->fill($request->input())->save();


       $notification = array(
           'message' => 'Registro actualizado correctamente',
           'alert-type' => 'info'
       );

       return redirect()->back()->with($notification);
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $validarEmpresa=Empresa::where('user_id',Auth::user()->id)->first();


        if (Auth::user()->rol!='is_admin_rol') {
             $galeria = Galeria::findOrfail($id);
            if ($validarEmpresa->id==$galeria->empresa_id) {

           

            if(!empty($galeria->url))
            {
                \Storage::disk('s3')->delete('empresas/'.$galeria->url);
            }

            $galeria->delete();

            $notification = array(
                'message' => 'Registro eliminado correctamente',
                'alert-type' => 'info'
            );
        }
        }  
        else{
            $galeria = Galeria::findOrfail($id);

            if(!empty($galeria->url))
            {
                \Storage::disk('s3')->delete('empresas/'.$galeria->url);
            }

            $galeria->delete();

            $notification = array(
                'message' => 'Registro eliminado correctamente',
                'alert-type' => 'info'
            );

        }
    }
}
