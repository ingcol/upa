<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Menu;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function store(Request $request)
    {
        $empresa = Empresa::withCount(['menus'])->findOrFail($request->input('empresa_id'));
        
        if($empresa->menus_count > 9 ){
            $notification = array(
                'message' => 'Solo puede agregar 10 imágenes',
                'alert-type' => 'warning'
            );
        } else {


            if($request->hasFile('file')) {

             $foto = Helper::uploadFileMenu( "file", 'menu/');
             $request->merge(['file' => $foto]);
         }

         $fotoo = Menu::create($request->input()); 


         $notification = array(
            'message' => 'Registro creado correctamente',
            'alert-type' => 'info'
        );
     }
     return redirect()->back()->with($notification);

 }

 public function update(Request $request)
    {

        $fotoo = Menu::findOrfail($request->id);

        if($request->hasFile('file')) 
        {
           if(!empty($fotoo->foto))
           {
               \Storage::disk('s3')->delete('menu/'.$fotoo->foto);
           }

           $foto = Helper::uploadFileMenu( "file", 'menu/');

           $request->merge(['file' => $foto]);
       }

       $fotoo->fill($request->input())->save();


       $notification = array(
           'message' => 'Registro actualizado correctamente',
           'alert-type' => 'info'
       );

       return redirect()->back()->with($notification);
   }

    public function upload(Request $request)
    {

        $empresa = Empresa::withCount(['menus'])->findOrFail($request->input('empresa_id'));

        if($empresa->menus_count > 9 ){
            abort(403, 'Solo puede agregar 10 imágenes');
        } else {


            if($request->hasFile('file')) {

               $foto = Helper::uploadFileMenu( "file", 'menu/');
               $request->merge(['file' => $foto]);
           }

           $fotoo = Menu::create($request->input()); 


           $notification = array(
            'message' => 'Registro creado correctamente',
            'alert-type' => 'info'
        );
       }
       return redirect()->back()->with($notification);

   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $validarEmpresa=Empresa::where('user_id',Auth::user()->id)->first();


        if (Auth::user()->rol!='is_admin_rol') {
             $menu = Menu::findOrfail($id);
            if ($validarEmpresa->id==$menu->empresa_id) {

           

            if(!empty($menu->file))
            {
                \Storage::disk('s3')->delete('menu/'.$menu->file);
            }

            $menu->delete();

            $notification = array(
                'message' => 'Registro eliminado correctamente',
                'alert-type' => 'info'
            );
        }
        }  
        else{
            $menu = Menu::findOrfail($id);

            if(!empty($menu->file))
            {
                \Storage::disk('s3')->delete('menu/'.$menu->file);
            }

            $menu->delete();

            $notification = array(
                'message' => 'Registro eliminado correctamente',
                'alert-type' => 'info'
            );

        }
    }
}
