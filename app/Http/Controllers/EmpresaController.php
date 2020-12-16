<?php

namespace App\Http\Controllers;

use App\Ciudad;
use App\Estado;
use App\Empresa;
use App\Categoria;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EnviarSugerencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RequestEmpresa;
use App\Http\Requests\EmpresaRequestStore;
use App\Http\Requests\EmpresaRequestUpdate;
use App\Http\Resources\Empresa as EmpresaResource;

class EmpresaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('sugerencia');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->rol=='is_admin_rol') {
         return view('empresa.index');
     }
     else{
        return view('errors.404');
    }

}
public function datos(Request $request){


    if (Auth::user()->rol=='is_admin_rol') {

     if ($request->filtrarCiudad=='-1' && $request->filtrarPlan=='-1' && $request->filtrarEstado=='-1') {

         $empresa=Empresa::orderBy('id','DESC')->get();

     }
     elseif ($request->filtrarCiudad!='-1' && $request->filtrarPlan=='-1' && $request->filtrarEstado=='-1') {
        $empresa=Empresa::orderBy('id','DESC')->where('ciudad_id',$request->filtrarCiudad)->get();
    }
    elseif ($request->filtrarCiudad!='-1' && $request->filtrarPlan!='-1' && $request->filtrarEstado=='-1') {
        $empresa=Empresa::orderBy('id','DESC')->where('ciudad_id',$request->filtrarCiudad)->where('plan',$request->filtrarPlan)->get();
    }
    elseif ($request->filtrarCiudad!='-1' && $request->filtrarPlan!='-1' && $request->filtrarEstado!='-1') {
        $empresa=Empresa::orderBy('id','DESC')->where('ciudad_id',$request->filtrarCiudad)->where('plan',$request->filtrarPlan)->where('estado',$request->filtrarEstado)->get();
    }

    elseif ($request->filtrarCiudad=='-1' && $request->filtrarPlan!='-1' && $request->filtrarEstado=='-1') {
        $empresa=Empresa::orderBy('id','DESC')->where('plan',$request->filtrarPlan)->get();
    }
    elseif ($request->filtrarCiudad=='-1' && $request->filtrarPlan!='-1' && $request->filtrarEstado!='-1') {
        $empresa=Empresa::orderBy('id','DESC')->where('plan',$request->filtrarPlan)->where('estado',$request->filtrarEstado)->get();
    }

     elseif ($request->filtrarCiudad!='-1' && $request->filtrarPlan=='-1' && $request->filtrarEstado!='-1') {
        $empresa=Empresa::orderBy('id','DESC')->where('ciudad_id',$request->filtrarCiudad)->where('estado',$request->filtrarEstado)->get();
    }
    elseif ($request->filtrarCiudad=='-1' && $request->filtrarPlan=='-1' && $request->filtrarEstado!='-1') {
        $empresa=Empresa::orderBy('id','DESC')->where('estado',$request->filtrarEstado)->get();
    }


    return  $empresa;


}
}

public function create() {

    $empresa = Empresa::where('user_id','=', Auth::user()->id)->with('galeria')->with('menus')->first();


    $estados = Estado::orderBy('nombre')->with('ciudades')->get();
    $categorias=Categoria::orderBy('nombre')->with('subcategorias')->get();

    if($empresa == null){

        $empresa = new Empresa;
        $btnText = __("Guardar");

        return view('empresa.create',compact('empresa','btnText','estados','categorias'));

    }else{
        $btnText = __("Actualizar");


        return view('empresa.create',compact('empresa','btnText','estados','categorias'));
    }

}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresaRequestStore $request)
    {
      /*  $request->validate([
            'name' => 'required|max:255',
        ]);
*/

        //dd($request->all());

        $slug = Str::slug($request->input('nombre'), "-");

        if($request->hasFile('logo')) {

         $logo = Helper::uploadFileLogo( "logo", '/logos/');
         $request->merge(['logo' => $logo]);
     }

     $request->merge(['slug' => $slug]);
     $request->merge(['user_id' => Auth::user()->id]);
     $empresa = Empresa::create($request->except('api_token'));

     $notification = array(
        'message' => 'Registro creado correctamente',
        'alert-type' => 'info'
    );

     return redirect()->route('empresas.create', compact('empresa'))->with($notification);
 }
    /**
     * Display the specified resource.
     *
     * @param  \App\Empresas  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresas $empresa)
    {
        //
    }
    public function listadoEmpresas(){
        if (Auth::user()->rol=='is_admin_rol') {

            return Empresa::get();

        }
    }

    public function edit($id){
        if (Auth::user()->rol=='is_admin_rol') {

            $empresa = Empresa::where('id','=', $id)->with('galeria')->with('menus')->first();


            $estados = Estado::orderBy('nombre')->with('ciudades')->get();
            $categorias=Categoria::orderBy('nombre')->with('subcategorias')->get();

            if($empresa == null){

                return view('errors.404');

            }else{
                $btnText = __("Actualizar");


                return view('empresa.edit',compact('empresa','btnText','estados','categorias'));
            }
        }else{
            return view('errors.404');

        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresas  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(EmpresaRequestUpdate $request, Empresa $empresa)
    {
        

        //dd($request,$empresa);
      //  $this->authorize('validar',$empresa);

        if($request->hasFile('logo')) 
        {
            if(!empty($empresa->logo))
            {
                \Storage::delete('/logos/'.$empresa->logo);
            }

            $logo = Helper::uploadFileLogo( "logo", '/logos/');

            $request->merge(['logo' => $logo]);
        }

        $empresa->fill($request->input())->save();


        $notification = array(
            'message' => 'Registro actualizado correctamente',
            'alert-type' => 'info'
        );
        if (Auth::user()->rol=='is_admin_rol') {
            return redirect()->route('empresas.index')->with($notification);
        }else{
           return redirect()->route('empresas.create', compact('empresa'))->with($notification);
       }
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresas  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        //
    }

    public function sugerencia(Request $request)
    {
        $request->validate([
            'sugerencia' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
        ]);



        $forminput = [
            'sugerencia' => $request->input('sugerencia'),
            'email' => $request->input('email'),
        ];


        /**
        * No olvides cambiar el correo aquí. 
        * Este es el correo donde vas a recibir 
        * los mensajes.
        **/
        Mail::to($request->input('email'))->send(new EnviarSugerencia($forminput));

        return "ok";
    }



}
