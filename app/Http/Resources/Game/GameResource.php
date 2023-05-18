<?php

namespace App\Http\Resources\Game;

use App\Http\Resources\Language\LanguageGameResourrce;
use App\Http\Resources\Language\LanguageResourrce;
use App\Models\GameLanguage;
use App\Models\GameMetaData;
use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

     
        $gameMetaData = GameMetaData:: where('gameId',$this->id)->first();
        if($gameMetaData){
            $metaData =(object)[
                "id"=> $gameMetaData->id,
                "key"=> $gameMetaData->key,
                "value"=> $gameMetaData->value,
            ];
        }
        $GameLanguage = GameLanguage::where('gameId',$this->id)->get();
        return empty($this->resource->toArray()) ? [] : [
            'id'=> $this->id,
            'Language'=>LanguageGameResourrce::collection($GameLanguage),
            'image'=> ($this->image)?asset('images/'.$this->image):"",
            'metadata'=> ($gameMetaData)? $metaData : null
        ];
    }
}

