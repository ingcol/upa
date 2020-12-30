<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = "calificaciones";
	protected $guarded = ['id'];

	public function empresa()
    {
       return $this->belongsTo(Empresa::class,'empresa_id');        
    }
}
