<?php

namespace App\Http\Controllers;

use App\Ciudad;
use App\Estado;
use App\Profesion;
use App\Profesional;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EnviarSugerencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class ProfesionalController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth')->except('sugerencia');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create() {
        
        $profesional = Profesional::where('user_id','=', Auth::user()->id)->first();

        
        $estados = Estado::orderBy('nombre')->with('ciudades')->get();
        $profesiones=Profesion::orderBy('nombre')->with('subprofesiones')->get();
     
        if($profesional == null){

            $profesional = new Profesional;
            $btnText = __("Guardar");
            
            return view('profesional.create',compact('profesional','btnText','estados','profesiones'));

        }else{
            $btnText = __("Actualizar");
            
            return view('profesional.create',compact('profesional','btnText','estados','profesiones'));
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      /*  $request->validate([
            'name' => 'required|max:255',
        ]);
*/
      
        $slug = Str::slug($request->input('nombre'), "-");
     
        if($request->hasFile('logo')) {
            
			$logo = Helper::uploadFileLogo( "logo", '/profesionales/');
			$request->merge(['logo' => $logo]);
        }

        $request->merge(['slug' => $slug]);
        $request->merge(['user_id' => Auth::user()->id]);
        $profesional = Profesional::create($request->except('api_token'));

        $notification = array(
            'message' => 'Registro creado correctamente',
            'alert-type' => 'info'
        );

        return redirect()->route('profesionales.create', compact('profesional'))->with($notification);
    }

    
    public function show(Profesional $profesional)
    {
        //
    }

    
    public function update(Request $request, Profesional $profesionale)
    {
        $profesional = $profesionale;
      //  $this->authorize('validar',$profesional);

        if($request->hasFile('logo')) 
        {
            if(!empty($profesional->logo))
            {
            //    dd($profesional->logo);
                \Storage::delete('/profesionales/'.$profesional->logo);
            }
        
            $logo = Helper::uploadFileLogo("logo", '/profesionales/');

       //     dd($logo);
			
			$request->merge(['logo' => $logo]);
        }
        
     //   $request->merge(['slug' => $profesional->slug]);

		$profesional->fill($request->input())->save();

  
        $notification = array(
            'message' => 'Registro actualizado correctamente',
            'alert-type' => 'info'
        );

        return redirect()->route('profesionales.create', compact('profesional'))->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profesional  $profesional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profesional $profesional)
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
