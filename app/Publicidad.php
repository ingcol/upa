<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Publicidad extends Model
{
    protected $table = "publicidades";
    protected $guarded = [];
    //protected $appends =  ["ciudad_nombre"];

    public function scopeCiudad($query,$ciudad)
    {
        if($ciudad)
        {
            return $query->where('ciudad_id',$ciudad);
        }
    }
    
	public function ciudad()
	{

		return $this->belongsTo(Ciudad::class,'ciudad_id');        
	}

}
