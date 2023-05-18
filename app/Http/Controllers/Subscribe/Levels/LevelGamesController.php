<?php

namespace App\Http\Controllers\Subscribe\Levels;

use App\Http\Controllers\Controller;
use App\Http\Resources\LevelGames\LevelGamesResource;
use App\Models\GameMetaData;
use App\Models\LevelMetaData;
use Illuminate\Http\Request;

class LevelGamesController extends Controller
{
    // public function index(Request $request){

    //     $LevelMetaData = LevelMetaData::where('levelId',$request->levelId)->get();

    //     if(count($LevelMetaData)== 0){
    //         return $this->sendMessage('no metadata to this game',400);
    //     }

    //     return $this->sendResponse(LevelGamesResource::collection($LevelMetaData),'Success',200);

    // }


}

