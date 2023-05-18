<?php

namespace App\Http\Resources\Subscriber;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return empty($this->resource->toArray()) ? [] : [
            'id'=> $this->id,
            'Msisdn'=> $this->Msisdn,
            'status'=> $this->status
        ];

    }
}
