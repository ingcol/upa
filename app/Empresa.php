<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Empresa;
use App\Promocion;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use  DatePeriod;

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
    public function calficaciones()
    {

        return $this->hasMany(Calificacion::class);        
    }
    public function menus()
    {

        return $this->hasMany(Menu::class,'empresa_id');        
    }


    public function subcategoria()
    {

        return $this->belongsTo(Subcategoria::class,'subcategoria_id');        
    }
    public function ciudad()
    {

        return $this->belongsTo(Ciudad::class,'ciudad_id');        
    }
    
    

    public function promocionestotal()
    {
        return $this->hasMany(Promocion::class,'empresa_id');        
    }

    public function getFechaActual(){
        $FechaActual= Carbon::now();
        return $FechaActual->format('Y-m-d');
        //date('w'); día actual
    }

    public function promociones(){
        $diaActual=date('w');
        
        if ($diaActual==0) {
            $where='domingo';

        }
        elseif ($diaActual==1) {
            $where='lunes';
        }
        elseif ($diaActual==2) {
            $where='martes';
        }
        elseif ($diaActual==3) {
            $where='miercoles';
        }
        elseif ($diaActual==4) {
            $where='jueves';
        }
        elseif ($diaActual==5) {
            $where='viernes';
        }
        else{
            $where='sabado';
        }

      return $this->hasMany(Promocion::class,'empresa_id')->where($where,$diaActual)->where('estado',1)->where('fechainicio','<=',$this->getFechaActual())->where('fechafin','>=',$this->getFechaActual());
    }
}
