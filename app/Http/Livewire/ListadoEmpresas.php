<?php

namespace App\Http\Livewire;

use App\Categoria;
use Livewire\Component;

class ListadoEmpresas extends Component
{
    public function render()
    {
        return view('livewire.listado-empresas', [
            'categorias' => Categoria::with('subcategorias')->get(),
        ]);
    }
}
