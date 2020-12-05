<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategoria;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\SubCategoriaRequestStore;
use App\Http\Requests\SubCategoriaRequestUpdate;
class SubCategoriaController extends Controller
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
        return view('subcategoria.index');
    }
    else{
        return view('errors.404');
    }
}

public function datos(){

    if (Auth::user()->rol=='is_admin_rol') {

        return Subcategoria::get();

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
    public function store(SubCategoriaRequestStore $request)
    {
       if (Auth::user()->rol=='is_admin_rol') {
        $subcategoria =SubCategoria::create($request->all());
        return response()->json($subcategoria);

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
    public function update(Request $request, $id)
    {
        if (Auth::user()->rol=='is_admin_rol') {
            $rules = [
               'nombre' => [
                'required','min:3',
                'unique:subcategorias,nombre,'.$id
            ],

            'categoria_id' => 'required|numeric',

        ];

        $messages = [
         'nombre.required' => 'El campo nombre no debe estar vacío',
         'nombre.unique' => 'El nombre ya esta registrado, utilice otro',
         'categoria_id.required' => 'El campo categoría no debe estar vacío',
         'categoria_id.numeric' => 'El campo categoría no debe estar vacío',
     ];

     $this->validate($request, $rules, $messages);
     $subcategoria=Subcategoria::find($id);
     $subcategoria->fill($request->all());
     $subcategoria->update();
     return $subcategoria;

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
