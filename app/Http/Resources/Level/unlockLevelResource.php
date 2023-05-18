<?php

namespace App\Http\Resources\Level;

use App\Http\Resources\Language\LanguageLevelResourrce;
use App\Http\Resources\LevelGames\LevelGamesResource;
use App\Models\Level;
use App\Models\LevelLanguage;
use App\Models\LevelMetaData;
use App\Models\Pool;
use Illuminate\Http\Resources\Json\JsonResource;

class unlockLevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $level = Level::find($request->levelId);
        // $levelMetaData = LevelMetaData::where('id',$this->id)->get();
        $levelMetaData = LevelMetaData::where('levelId',$request->levelId)->get();
        $LevelLanguage = LevelLanguage::where('levelId',$level->id)->get();
        return empty($this->resource->toArray()) ? [] : [
            'id'=> $level->id,
            'gameId'=> $level->gameId,
            'number'=> $level->number,
            'poolId'=> $level->poolId,
            'pool_name'=> (Pool::find($level->poolId)->name)?Pool::find($level->poolId)->name:" ",
            'tries'=>  $level->tries,
            'rounds'=> $level->rounds,
            'Language'=>LanguageLevelResourrce::collection($LevelLanguage),
            'state'=>'P',
            'metaData' => ($levelMetaData)?LevelGamesResource::collection($levelMetaData) : null
        ];
    }
}
