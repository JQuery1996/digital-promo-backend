<?php

namespace App\Http\Resources\Award;

use App\Models\Award;
use App\Models\Game;
use App\Models\Level;
use Illuminate\Http\Resources\Json\JsonResource;

class AwardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

          $game = Game::find($this->gameId);
          $aword = Award::find($this->awardId);
          $level = Level::find($this->levelId)->where('gameId',$this->gameId)->first();
        return empty($this->resource->toArray()) ? [] : [
            'id'=> $this->id,
            'game_id'=> $game->id,
            'game_name'=> $game->route,
            'game_image'=> $game->image,
            'aword_type'=> $aword->type,
            'aword_subType'=> $aword->subType,
            'aword_name'=> $aword->name,
            'level_number'=> $level->number,
        ];
    }
}


