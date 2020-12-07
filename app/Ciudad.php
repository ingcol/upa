<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
	protected $table = "ciudades";
	protected $guarded = ['id'];

	protected $appends =  ["departamento_nombre"];

	public function getDepartamentoNombreAttribute(){

		return $this->departamento()->first()->nombre ?? '';
	}

	public function departamento(){
		return $this->belongsTo(Estado::class,'estado_id'); 
	}



}
