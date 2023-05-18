<?php

namespace App\Http\Resources\Language;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageLevelResourrce extends JsonResource
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
            'LanguageId'=>$this->languageId,
            'Description'=>$this->description
        ];
    }
}
