<?php

namespace App\Http\Resources\Language;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageGameResourrce extends JsonResource
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
            'Name'=>$this->name,
            'Description'=>$this->description,
            'LanguageId'=>$this->languageId,


        ];
    }
}

