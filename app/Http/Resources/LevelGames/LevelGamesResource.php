<?php

namespace App\Http\Resources\LevelGames;

use Illuminate\Http\Resources\Json\JsonResource;

class LevelGamesResource extends JsonResource
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
            'levelId'=> $this->levelId,
            'key'=> $this->key,
            'value'=> $this->value,

        ];
    }
}

