<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    protected $table = "profesiones";
    protected $guarded = ['id'];

//    protected $with = ['subcategorias'];
   
    public function subprofesiones()
    {
            return $this->hasMany(Subprofesion::class);        
    }

    public function subprofesionesP()
    {
            return $this->hasMany(Subprofesion::class)->has('profesionales');        
    }

}
