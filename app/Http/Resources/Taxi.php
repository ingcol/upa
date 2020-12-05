<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Taxi extends JsonResource
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
            'nombre' => $this->nombre,
            'celular' => $this->celular,
            'logo' => $this->logo,
            'ciudad_id' => $this->ciudad_id,
        ];
    }
}
