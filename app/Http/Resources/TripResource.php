<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
            'date' => Carbon::parse($this->date)->format('m/d/Y'),
            'year' => $this->year,
            'miles' => $this->miles,
            'total' => $this->total,
            'car' => $this->car ? new CarResource($this->car) : [],
        ];
    }

}
