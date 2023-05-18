<?php

namespace App\Http\Resources\Award;

use App\Enums\Constant;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberAwardResource extends JsonResource
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
            'ExternalId'=> $this->id,
            'operatorName'=>( $this->operatorId == 6 )? Constant::ACOUNT_NAME_MTN : Constant::ACOUNT_NAME_SYRIATEL,
            'type'=> $this->type,
            'subType'=> $this->subType,
            'name'=> $this->name,
        ];
    }
}
