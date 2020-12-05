<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
	protected $table = "promociones";
	protected $guarded = ['id'];
	protected $appends =  ["empresa_nombre"];
	public function getEmpresaNombreAttribute(){
		return $this->empresa()->first(['nombre'])->nombre;
	}
	public function empresa()
	{

		return $this->belongsTo(Empresa::class,'empresa_id');        
	}
}
