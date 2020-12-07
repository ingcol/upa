<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = "estados";
    protected $guarded = [];
    protected $appends =  ["pais_nombre"];


   public function getPaisNombreAttribute(){

		return $this->pais()->first()->nombre ?? '';
	}
    public function ciudades()
    {
            return $this->hasMany(Ciudad::class);        
    }
    public function pais(){
		return $this->belongsTo(Pais::class,'pais_id'); 
	}


}
