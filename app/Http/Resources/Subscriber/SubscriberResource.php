<?php

namespace App\Http\Resources\Subscriber;

use App\Http\Resources\Award\AwardResource;
use App\Models\AwardsLog;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $Awards = AwardsLog::where('Msisdn',$request->Msisdn)->get();

        return empty($this->resource->toArray()) ? [] : [
            'id'=> $this->id,
            'Msisdn'=> $this->Msisdn,
            'awards'=> (AwardResource::collection($Awards))? AwardResource::collection($Awards):[] ,
        ];
    }
}


