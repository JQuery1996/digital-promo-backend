<?php

namespace App\Http\Controllers\Subscribe\Levels;

use App\Enums\Constant;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question\QuestionPoolResourrce;
use App\Models\Level;
use App\Models\LevelMetaData;
use App\Models\Question;
use App\Models\QuestionPool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
     public function index(Request $request){

        $request->Msisdn =Auth::user()->Msisdn;
        $game_id = Level::find($request->levelId);
        if(!$game_id){
            return $this->sendMessage(__('message.Technical Error'),400);
        }

        if($game_id ->gameId != Constant::QUESTION_GAME_ID){
            return $this->sendMessage(__('message.Technical Error'),400);
        }

        $questionPool = QuestionPool::where('levelId',$request->levelId)->first();

        if(!$questionPool){
            return $this->sendMessage(__('message.not avilabel questions'),400);
        }
        $countQustions = Question::where('questionPoolId',$questionPool->id)->get();

        $metaData = LevelMetaData::where('levelId',$request->levelId)
        ->where('key','questionsCount')->first();

        $questionsCount = min((integer)$metaData->value,count($countQustions));

        $data = [
            'QuestionCount' => $questionsCount,
            'Questions' => new QuestionPoolResourrce($questionPool)
        ] ;
        return $this->sendResponse($data,__('message.Success'),200);

     }
}
