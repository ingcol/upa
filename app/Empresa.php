<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{

    protected $table =    "empresas";
    protected $guarded =  ['id'];
    protected $appends =  ["subcategoria_nombre","nombre_ciudad","user_name"];


    


    public function getSubcategoriaNombreAttribute(){
       
        return $this->subcategoria()->first()->nombre ?? '';
    }
    public function getNombreCiudadAttribute(){
        
        return $this->ciudad()->first()->nombre ?? '';
    }
    public function getUserNameAttribute(){
       
        return $this->user()->first()->name ?? '';
    }

    public function user()
    {
       return $this->belongsTo(User::class,'user_id');        
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class)->with('usuario');        
    }
    public function galeria()
    {

        return $this->hasMany(Galeria::class);        
    }


    public function subcategoria()
    {

        return $this->belongsTo(Subcategoria::class,'subcategoria_id');        
    }
    public function ciudad()
    {

        return $this->belongsTo(Ciudad::class,'ciudad_id');        
    }
    
    

    public function promociones()
    {
        return $this->hasMany(Promocion::class,'empresa_id');        
    }
}
