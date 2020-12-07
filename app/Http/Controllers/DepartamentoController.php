<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;
use App\Pais;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DepartamentoRequestStore;
use App\Http\Requests\DepartamentoRequestUpdate;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->middleware('auth');
        

    }
    public function index()
    {
     if (Auth::user()->rol=='is_admin_rol') {
        return view('departamento.index');
    }
    else{
        return view('errors.404');
    }

}
public function datos(){

    if (Auth::user()->rol=='is_admin_rol') {

        return Estado::with('ciudades')->get();

    }

}

public function paises(){

    if (Auth::user()->rol=='is_admin_rol') {

        return Pais::get();

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
    public function store(DepartamentoRequestStore $request)
    {
        if (Auth::user()->rol=='is_admin_rol') {
            $estado =Estado::create($request->all());
            return response()->json($estado);

        }
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
    public function update(DepartamentoRequestUpdate $request, $id)
    {
        $estado=Estado::find($id);
        $estado->fill($request->all());
        $estado->update();
        return $estado;
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
