<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Domicilio extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'celular' => $this->celular,
            'whatsapp' => $this->whatsapp,
            'descripcion' => $this->descripcion,
        ];
    }
}
