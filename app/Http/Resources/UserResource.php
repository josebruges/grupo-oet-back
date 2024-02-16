<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type' => 'users',
            'id' => (string) $this->resource->id,
            'attributes' => [
                'nombres' => $this->resource->nombres,
                'apellidos' => $this->resource->apellidos,
                'cedula' => $this->resource->cedula,
                'correo' => $this->resource->correo,
                'telefono' => $this->resource->telefono
            ],
            'links' => [
                'self' => url('api/users/' . $this->resource->id)
            ]
        ];
    }
}
