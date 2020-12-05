<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = "valoraciones";
    protected $guarder = ['id'];
    protected $fillable = ['comentario','valor','user_id','empresa_id'];


    public function usuario()
    {
                return $this->belongsTo(User::class, 'user_id');        
      
    }

  
}
