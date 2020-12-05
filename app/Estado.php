<?php

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = "estados";
    protected $guarded = [];


   
    public function ciudades()
    {
            return $this->hasMany(Ciudad::class);        
    }


}
