<?php

namespace App\Http\Controllers\Subscribe\Games;

use App\Http\Controllers\Controller;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Traits\Response;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function index(){

        $games = Game::all();

        if(count($games)==0){
            return $this->sendMessage(__('message.not avilabel games'));
        }

        return $this->sendResponse(GameResource::collection($games),__('message.Success'),200) ;

    }


    public function gameInfo($gameId){

        $games = Game::find($gameId);

        if(!$games){
            return $this->sendMessage(__('message.not avilabel game'));
        }

        return $this->sendResponse(new GameResource($games),__('message.Success'),200) ;

    }
}
