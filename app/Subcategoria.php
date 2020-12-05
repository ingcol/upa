<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
	protected $table = "subcategorias";
	protected $guarded = ['id'];
	protected $appends =  ["categoria_nombre"];

//    protected $with = ['empresas'];
	public function getCategoriaNombreAttribute(){

		return $this->categoria()->first()->nombre ?? '';
	}
	public function empresas()
	{
		return $this->hasMany(Empresa::class)->with('galeria')->where('estado','=','1');
	}

	public function categoria(){
		return $this->belongsTo(Categoria::class,'categoria_id'); 
	}

}
