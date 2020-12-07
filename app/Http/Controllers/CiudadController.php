<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CiudadRequestStore;
use App\Http\Requests\CiudadRequestUpdate;
use Illuminate\Support\Facades\Storage;
class CiudadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->middleware('auth');
        set_time_limit(8000000);
        

    }
    public function index()
    {
        if (Auth::user()->rol=='is_admin_rol') {
            return view('ciudad.index');
        }
        else{
            return view('errors.404');
        }
    }

    public function datos(){

        if (Auth::user()->rol=='is_admin_rol') {

            return Ciudad::get();

        }

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
    public function store(CiudadRequestStore $request)
    {
        $ciudad=new Ciudad;
        $ciudad->nombre=$request->nombre;
        $ciudad->estado_id=$request->estado_id;
        if ($request->hasFile('imagen')) {

            $type=$request->imagen->getClientOriginalExtension();

            if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
                return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
            }
            else{

                $nameFile = $request->imagen;
                $newName =time().rand().'.'.$nameFile->getClientOriginalExtension();

                      //amazon
                $path = $nameFile->storeAs('ciudades', $newName,'s3');
                Storage::disk('s3')->setVisibility($path, 'public');

                $ciudad->imagen=$newName;

            }



        }
        if ($request->hasFile('banner')) {

            $type=$request->banner->getClientOriginalExtension();

            if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
                return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
            }
            else{

                $nameFile = $request->banner;
                $newName =time().rand().'.'.$nameFile->getClientOriginalExtension();

                      //amazon
                $path = $nameFile->storeAs('ciudades', $newName,'s3');
                Storage::disk('s3')->setVisibility($path, 'public');

                $ciudad->banner=$newName;

            }



        }

        $ciudad->save();

        return $ciudad;
    }

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
    public function update(CiudadRequestUpdate $request, $id)
    {

        $ciudad=Ciudad::find($id);
        $ciudad->nombre=$request->nombre;
        $ciudad->estado_id=$request->estado_id;
        if ($request->hasFile('imagen')) {

            $type=$request->imagen->getClientOriginalExtension();

            if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
                return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
            }
            else{

                $nameFile = $request->imagen;
                $newName =time().rand().'.'.$nameFile->getClientOriginalExtension();

                      //amazon
                $path = $nameFile->storeAs('ciudades', $newName,'s3');
                Storage::disk('s3')->setVisibility($path, 'public');

                $ciudad->imagen=$newName;

            }



        }
        if ($request->hasFile('banner')) {

            $type=$request->banner->getClientOriginalExtension();

            if ($type!="png" && $type!="jpeg"&& $type!="jpg"&& $type!="gif") {
                return response()->json(['errors' => ['message' => ['El formato de la imagen no es válido']]], 422);
            }
            else{

                $nameFile = $request->banner;
                $newName =time().rand().'.'.$nameFile->getClientOriginalExtension();

                      //amazon
                $path = $nameFile->storeAs('ciudades', $newName,'s3');
                Storage::disk('s3')->setVisibility($path, 'public');

                $ciudad->banner=$newName;

            }



        }

        $ciudad->update();

        return $ciudad;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
