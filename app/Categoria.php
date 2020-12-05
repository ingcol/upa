<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = "categorias";
    protected $guarded = ['id'];

//    protected $with = ['subcategorias'];
   
    public function subcategorias()
    {
            return $this->hasMany(Subcategoria::class)->has('empresas');        
    }


}
