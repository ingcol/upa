<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoriaRequestStore;
use App\Http\Requests\CategoriaRequestUpdate;
class CategoriaAdminController extends Controller
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

            return view('categoria.index');
        }
        else{
            return view('errors.404');
        }
    }

    public function datos(){
        if (Auth::user()->rol=='is_admin_rol') {

            return Categoria::orderBy('id','DESC')->select('id','nombre')->get();

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
    public function store(CategoriaRequestStore $request)
    {  

        if (Auth::user()->rol=='is_admin_rol') {
            $categoria =Categoria::create($request->all());
            return response()->json($categoria);

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
    public function update(CategoriaRequestUpdate $request, $id)
    {
        if (Auth::user()->rol=='is_admin_rol') {
            $categoria=Categoria::find($id);
            $categoria->fill($request->all());
            $categoria->update();
            return $categoria;

        }
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
