<?php

namespace App\Http\Resources\Level;

use App\Http\Resources\Language\LanguageLevelResourrce;
use App\Http\Resources\LevelGames\LevelGamesResource;
use App\Models\Level;
use App\Models\LevelLanguage;
use App\Models\LevelMetaData;
use App\Models\Pool;
use Illuminate\Http\Resources\Json\JsonResource;

class firstLevelResource extends JsonResource
{


    public function __construct($resource) {

        $this->resource = $resource;


    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $LevelMetaData = LevelMetaData::where('levelId',$this->id)->get();
        $gameLevel = Level::where('gameId',$request->gameId)->first();
        $LevelLanguage = LevelLanguage::where('levelId',$this->id)->get();
        return empty($this->resource->toArray()) ? [] : [
            'id'=> $this->id,
            'gameId'=> $this->gameId,
            'number'=> $this->number,
            'poolId'=> $this->poolId,
            'pool_name'=> (Pool::find($this->poolId)->name)?Pool::find($this->poolId)->name:" ",
            'tries'=>  $this->tries,
            'rounds'=> $this->rounds,
            'Language'=>LanguageLevelResourrce::collection($LevelLanguage),
            'state'=>($gameLevel->number== $this->number)?'P':'C',
            'metaData' => ($LevelMetaData)?LevelGamesResource::collection($LevelMetaData) : null
        ];
    }
}

