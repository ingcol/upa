<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Estado extends JsonResource
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
            'eslogan' => $this->eslogan,
            'ciudades' => Ciudad::collection($this->ciudades),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
