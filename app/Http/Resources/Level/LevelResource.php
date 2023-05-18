<?php

namespace App\Http\Resources\Level;

use App\Http\Resources\Language\LanguageLevelResourrce;
use App\Http\Resources\LevelGames\LevelGamesResource;
use App\Models\Level;
use App\Models\LevelLanguage;
use App\Models\LevelMetaData;
use App\Models\Pool;
use App\Models\SubscriberLevel;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $subscriberLevels = SubscriberLevel::select('levelId')->where('Msisdn',$request->Msisdn)
        ->where('gameId',$request->gameId)->where('status','=','P')->get();
         $subscriberOpeneLevels =[];

         foreach($subscriberLevels as $subscriberLevel)
         array_push($subscriberOpeneLevels,$subscriberLevel->levelId);

        $LevelMetaData = LevelMetaData::where('levelId',$this->id)->get();
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
            'state'=>(in_array($this->number,$subscriberOpeneLevels,true))?'P':'C',
            'metaData' => ($LevelMetaData)?LevelGamesResource::collection($LevelMetaData) : null
        ];
    }
}
