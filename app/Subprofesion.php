<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Subprofesion extends Model
{
    protected $table = "subprofesiones";
    protected $guarded = ['id'];

//    protected $with = ['empresas'];

    public function profesionales()
    {
        return $this->hasMany(Profesional::class)->where('estado','=','1');
    }

}
