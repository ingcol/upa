<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{

    protected $table = "profesionales";
    protected $guarded = ['id'];


    public function valoraciones()
    {
            return $this->hasMany(Valoracion::class)->with('usuario');        
    }
}
