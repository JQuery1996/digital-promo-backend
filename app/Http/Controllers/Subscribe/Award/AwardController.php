<?php

namespace App\Http\Controllers\Subscribe\Award;

use App\Http\Controllers\Controller;
use App\Http\Resources\Award\SubscriberAwardResource;
use App\Models\Award;
use App\Models\AwardPool;
use App\Models\AwardsLog;
use App\Models\Level;
use App\Models\Subscriber;
use App\Models\SubscriberLevel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AwardController extends Controller
{
    public function winAward(Request $request){

        // try{

            $subscriberAuth = Auth::user();
            $subscriber = Subscriber::where('Msisdn', $subscriberAuth->Msisdn)->first();
            // $subscriberDaliyBalance = $subscriber->daliyBalanceValue;
            $level = Level::find($request->levelId);
////////////////++++
            $subscriberLevels = SubscriberLevel::where('Msisdn', $subscriberAuth->Msisdn)
            ->where('gameId',$request->gameId)->where('levelId',$level->number)->get();

            if(count($subscriberLevels)!=0){

                foreach($subscriberLevels as $subscriberLevel){
                    $subscriberLevel->update([
                        'status' => 'C'
                    ]);
                }
                
            }


            // $nextLevelNumber = $request->levelId + 1;
            // $nextLevel = Level::where('gameId',$request->gameId)->where('number',$nextLevelNumber)->first();
            // if($nextLevel){
            //     $subscriberLevel->update([
            //         'levelId' =>$nextLevelNumber,
            //     ]);
            // }else{
            //     $subscriberLevel->update([
            //         'levelId' => 1,
            //     ]);
            // }
///////////////////+++

            $awards = AwardPool::where('remaining','>',0)->get();


            if(count($awards) == 0){

                return $this->sendMessage(__('message.No award pool'),400);
            }
            $award_arr =[];
            foreach($awards as $award){

                array_push($award_arr,$award->awardId);
            }

            $randoumAward=$award_arr[array_rand($award_arr)];

            $awardSubscriber = Award::find($randoumAward);

            $award_log = AwardsLog::create([
                'awardId' => $awardSubscriber->id,
                'levelId' => $request->levelId,
                'gameId'  => $request->gameId,
                'Msisdn'  => $subscriberAuth->Msisdn,
                'CreationTimestamp' => now(),
            ]);

            return $this->sendResponse(new SubscriberAwardResource($awardSubscriber),'Success',200);

        // }catch(Exception $e){
        //     return $this->sendMessage(__('message.Technical Error'),400);
        // }


    }

}
// daliyBalanceValue
//
