<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'model' => $this->model,
            'make' => $this->make,
            'year' => $this->year,
            'trip_count' => $this->trip_count,
            'trip_miles' => $this->trip_miles,
        ];
    }

}
